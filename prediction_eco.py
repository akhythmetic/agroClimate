import requests
import pandas as pd
import numpy as np
import seaborn as sns
import plotly.express as px
import matplotlib.pyplot as plt
import pickle
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler, LabelEncoder
from sklearn.ensemble import RandomForestRegressor
from sklearn.metrics import mean_absolute_error, mean_squared_error, r2_score
import streamlit as st

# 1. Récupération des données depuis l'API PHP
url = "http://localhost/Gestiondeprojets/bd.php"
response = requests.get(url)

if response.status_code == 200:
    data = response.json()
    if "error" in data:
        st.error("Erreur :", data["error"])
        exit()
else:
    st.error(f"Erreur lors de la requête, code : {response.status_code}")
    exit()

st.write("Réponse API (extrait) :", data[:2])  # Vérification

# 2. Conversion en DataFrame Pandas
df = pd.DataFrame(data)

# 3. Exploration des données
st.write(df.info())  
st.write(df.describe())
st.write("Valeurs manquantes avant traitement :", df.isnull().sum())

# 4. Prétraitement des données
df.drop(columns=['Pays', 'Region'], errors='ignore', inplace=True)

# Encodage des variables catégorielles
label_encoders = {}
for col in ['Type_culture', 'Strategies_adaptation']:
    le = LabelEncoder()
    df[col] = le.fit_transform(df[col].astype(str))
    label_encoders[col] = le

# Sauvegarde des encodeurs
with open('label_encoders.pkl', 'wb') as f:
    pickle.dump(label_encoders, f)

df['Annee'] = pd.to_numeric(df['Annee'], errors='coerce').astype('Int64')

# Conversion des colonnes numériques
cols_to_convert = ['Temperature_moyenne', 'Precipitations_totales', 'Emissions_CO2',
                   'Rendement_agricole', 'Nb_d_evenements_climatiques_extremes',
                   'pourcentage_irrigation', 'Pesticides_kg_per_HA', 'Engrais_kg_per_HA',
                   'Indice_de_sante_des_sols', 'Impact_economique']
df[cols_to_convert] = df[cols_to_convert].apply(pd.to_numeric, errors='coerce')

# Vérification après conversion
st.write(df.dtypes)

# Remplacement des valeurs NaN
df.fillna(df.mean(), inplace=True)

# 5. Séparation des variables X et y
X = df.drop(columns=['Impact_economique'])
y = df['Impact_economique']

# Normalisation des données
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# 6. Séparation des données en train/test
X_train, X_test, y_train, y_test = train_test_split(X_scaled, y, test_size=0.2, random_state=42)

# 7. Entraînement du modèle RandomForestRegressor
model = RandomForestRegressor(n_estimators=100, random_state=42)
model.fit(X_train, y_train)

# 8. Prédictions et évaluation du modèle
y_pred = model.predict(X_test)

mae = mean_absolute_error(y_test, y_pred)
mse = mean_squared_error(y_test, y_pred)
rmse = np.sqrt(mse)
r2 = r2_score(y_test, y_pred)
mape = np.mean(np.abs((y_test - y_pred) / y_test)) * 100  # Ajout du MAPE

st.write(f'MAE: {mae:.2f}')
st.write(f'RMSE: {rmse:.2f}')
st.write(f'R² Score: {r2:.2f}')
st.write(f'MAPE: {mape:.2f}%')

# Création du DataFrame avec les importances
feature_importances = pd.DataFrame({'Feature': X.columns, 'Importance': model.feature_importances_})
feature_importances = feature_importances.sort_values(by='Importance', ascending=False)

# Création du graphique interactif
fig = px.bar(feature_importances, 
             x='Importance', 
             y='Feature', 
             orientation='h', 
             title='Importance des variables',
             labels={'Importance': 'Score d\'importance', 'Feature': 'Variable'},
             text_auto='.2f')

fig.update_layout(yaxis={'categoryorder':'total ascending'})  # Trie les variables par importance
st.plotly_chart(fig)

# 9. Interaction avec l'utilisateur
# Demander à l'utilisateur de saisir une valeur (par exemple, une année)
year_input = st.number_input("Entrez l'année pour laquelle vous souhaitez voir les prédictions :",
                            min_value=int(df['Annee'].min()), max_value=int(df['Annee'].max()), value=int(df['Annee'].min()))

# Filtrer les données en fonction de l'année entrée
filtered_df = df[df['Annee'] == year_input]

if not filtered_df.empty:
    # Prédire l'impact économique pour l'année donnée
    X_filtered = filtered_df.drop(columns=['Impact_economique'])
    X_filtered_scaled = scaler.transform(X_filtered)
    y_pred_filtered = model.predict(X_filtered_scaled)

    # Ajouter les prédictions au DataFrame filtré
    filtered_df['Impact_economique_pred'] = y_pred_filtered

    # Restaurer les noms des types de culture en utilisant le LabelEncoder
    filtered_df['Type_culture'] = label_encoders['Type_culture'].inverse_transform(filtered_df['Type_culture'])
    filtered_df['Strategies_adaptation'] = label_encoders['Strategies_adaptation'].inverse_transform(filtered_df['Strategies_adaptation'])

    # Création du graphique des prédictions
    fig2 = px.bar(filtered_df,
                  x='Type_culture',
                  y='Impact_economique_pred',
                  title=f'Impact économique prédit pour l\'année {year_input}',
                  labels={'Type_culture': 'Type de culture', 'Impact_economique_pred': 'Impact économique prédit'},
                  color='Strategies_adaptation')

    st.plotly_chart(fig2)
else:
    st.warning(f"Aucune donnée disponible pour l'année {year_input}.")
