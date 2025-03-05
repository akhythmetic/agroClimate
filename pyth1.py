from flask import Flask, request, jsonify
import mysql.connector
import pandas as pd
from sklearn.linear_model import LinearRegression


# 📌 Connexion à la base de données locale
def get_data_from_db():
    connection = mysql.connector.connect(
        host="localhost",
        user="root",  # Change selon ton utilisateur MySQL
        password="root",  # Mets ton mot de passe MySQL ici
        database="gestion_projet"
    )
    

    query = "select DISTINCT temperature_moyenne, precipitations_totales, CO2_emissions_MT, rendement_agricole_MT_per_HA from climat, pays, agriculture where climat.id_pays = pays.id_pays and agriculture.id_pays = pays.id_pays;"
    df = pd.read_sql(query, connection)
    connection.close()

    return df


  # Vérifier les types de données

# 📌 Charger les données et entraîner le modèle
df = get_data_from_db()
X = df[["temperature_moyenne", "precipitations_totales", "CO2_emissions_MT"]]
y = df["rendement_agricole_MT_per_HA"]

model = LinearRegression()
model.fit(X, y)

# 📌 Création de l'API Flask
app = Flask(__name__)


@app.route("/predict", methods=["POST"])
def predict():
    data = request.get_json()

    temperature = data["temperature"]
    precipitation = data["precipitation"]
    co2 = data["co2"]

    prediction = model.predict([[temperature, precipitation, co2]])[0]

    return jsonify({"prediction": prediction})


if __name__ == "__main__":
    app.run(debug=True)
