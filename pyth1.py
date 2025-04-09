from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector
import pandas as pd
from sklearn.linear_model import LinearRegression

app = Flask(__name__)
CORS(app, origins="http://localhost:8888")

# Connexion à la base de données
def get_data_from_db():
    connection = mysql.connector.connect(
        host="localhost",
        port=8889,
        user="root",
        password="root",
        database="gestion_projet"
    )
    query = """
    SELECT DISTINCT temperature_moyenne, precipitations_totales, CO2_emissions_MT, rendement_agricole_MT_per_HA 
    FROM climat, pays, agriculture 
    WHERE climat.id_pays = pays.id_pays AND agriculture.id_pays = pays.id_pays;
    """
    df = pd.read_sql(query, connection)
    connection.close()
    return df

# données
df = get_data_from_db()
X = df[["temperature_moyenne", "precipitations_totales", "CO2_emissions_MT"]]
y = df["rendement_agricole_MT_per_HA"]

model = LinearRegression()
model.fit(X, y)

@app.route("/predict", methods=["POST", "OPTIONS"])
def predict():
    if request.method == "OPTIONS":
        # CORS
        response = jsonify({'message': 'CORS preflight successful'})
        response.headers.add('Access-Control-Allow-Origin', '*')
        response.headers.add('Access-Control-Allow-Headers', 'Content-Type')
        response.headers.add('Access-Control-Allow-Methods', 'POST, OPTIONS')
        return response

    data = request.get_json()
    temperature = data.get("temperature")
    precipitation = data.get("precipitation")
    co2 = data.get("co2")

    if None in (temperature, precipitation, co2):
        return jsonify({"error": "Paramètres manquants"}), 400

    prediction = model.predict([[temperature, precipitation, co2]])[0]
    return jsonify({"prediction": prediction})

if __name__ == "__main__":
    app.run(debug=True, port=5000)
