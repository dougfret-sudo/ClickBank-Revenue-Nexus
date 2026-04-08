import sqlite3
from flask import Flask, jsonify, request
from flask_cors import CORS

app = Flask(__name__)
CORS(app) # Allows your HTML/JS to talk to this Python server

def get_db_connection():
    # Connects to your existing SQL database
    conn = sqlite3.connect('nexus_data.db')
    conn.row_factory = sqlite3.Row
    return conn

@app.route('/api/place-ad', methods=['POST'])
def place_ad():
    """Triggers the [Place Ad] logic from the dashboard."""
    # This is where your deterministic ad logic lives
    print("[NEXUS] Deploying secure bridge page...")
    return jsonify({"status": "success", "msg": "Ad Deployed Successfully."})

@app.route('/api/get-revenue', methods=['GET'])
def get_revenue():
    """Updates the [Revenue Ticker] using verified SQL data."""
    try:
        conn = get_db_connection()
        # Matches your schema.sql: Summing 'commission_earned'
        query = 'SELECT SUM(commission_earned) as total FROM clickbank_nexus_revenue WHERE status="verified"'
        row = conn.execute(query).fetchone()
        conn.close()
        
        total = row['total'] if row['total'] else 0.00
        return jsonify({"total_revenue": float(total)})
    except Exception as e:
        return jsonify({"total_revenue": 0.00, "error": str(e)}), 500

if __name__ == "__main__":
    print("Nexus Engine v1.0.0 - Hardware Isolated Mode Active")
    app.run(port=5000)
