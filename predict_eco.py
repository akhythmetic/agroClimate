import requests
import pandas as pd
import numpy as np
import plotly.express as px
import pickle
import sys
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.ensemble import RandomForestRegressor

# =====================
# Récupérer les arguments
# =====================
try:
    year_input = int(sys.argv[1])
    type_culture_input = sys.argv[2]
except (IndexError, ValueError):
    print("Erreur : Veuillez fournir une année et un type de culture valides.")
    sys.exit(1)

# =====================
# Récupération des données depuis l’API PHP
# =====================
url = "http://localhost/Gestiondeprojets/bd.php"
try:
    response = requests.get(url)
    response.raise_for_status()
    data = response.json()
except Exception as e:
    print(f"Erreur lors de la récupération des données : {e}")
    sys.exit(1)

df = pd.DataFrame(data)

# =====================
# Nettoyage et prétraitement
# =====================
df.drop(columns=['Pays', 'Region'], errors='ignore', inplace=True)

# Encodage des variables catégorielles
label_encoders = {}
for col in ['Type_culture', 'Strategies_adaptation']:
    le = LabelEncoder()
    df[col] = le.fit_transform(df[col].astype(str))
    label_encoders[col] = le

# Sauvegarde (facultatif)
with open('label_encoders.pkl', 'wb') as f:
    pickle.dump(label_encoders, f)

# Conversion des colonnes numériques
df['Annee'] = pd.to_numeric(df['Annee'], errors='coerce').astype('Int64')
cols_to_convert = [
    'Temperature_moyenne', 'Precipitations_totales', 'Emissions_CO2',
    'Rendement_agricole', 'Nb_d_evenements_climatiques_extremes',
    'pourcentage_irrigation', 'Pesticides_kg_per_HA', 'Engrais_kg_per_HA',
    'Indice_de_sante_des_sols', 'Impact_economique'
]
df[cols_to_convert] = df[cols_to_convert].apply(pd.to_numeric, errors='coerce')

# Gestion des valeurs manquantes
df.fillna(df.mean(numeric_only=True), inplace=True)

# =====================
# Filtrage + Prédiction
# =====================
try:
    print("Cultures disponibles :", label_encoders['Type_culture'].classes_)
    type_culture_encoded = label_encoders['Type_culture'].transform([type_culture_input])[0]
except ValueError:
    print(f"Type de culture inconnu : {type_culture_input}")
    sys.exit(1)

df_filtered = df[(df['Annee'] == year_input) & (df['Type_culture'] == type_culture_encoded)]

if df_filtered.empty:
    print(f"Aucune donnée disponible pour {type_culture_input} en {year_input}.")
    sys.exit(0)

# =====================
# Modélisation simple
# =====================
X_filtered = df_filtered.drop(columns=['Impact_economique'])
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X_filtered)

model = RandomForestRegressor(n_estimators=100, random_state=42)
model.fit(X_scaled, df_filtered['Impact_economique'])

y_pred = model.predict(X_scaled)
df_filtered = df_filtered.copy()
df_filtered['Impact_economique_pred'] = y_pred

# Inversion de l'encodage pour la légende
if df_filtered['Strategies_adaptation'].dtype == 'int64':
    df_filtered['Strategies_adaptation'] = label_encoders['Strategies_adaptation'].inverse_transform(
        df_filtered['Strategies_adaptation']
    )

# =====================
# Génération du graphique
# =====================
fig = px.bar(
    df_filtered,
    x='Strategies_adaptation',
    y='Impact_economique_pred',
    title=f"Impact économique prédit pour {type_culture_input} en {year_input}",
    labels={
        'Strategies_adaptation': 'Stratégie d\'adaptation',
        'Impact_economique_pred': 'Impact économique prédit'
    },
    color='Strategies_adaptation'
)

# =====================
# Sortie HTML du graphique (sans HTML complet)
# =====================
html_graph = fig.to_html(full_html=False, include_plotlyjs=False)
print(html_graph)
