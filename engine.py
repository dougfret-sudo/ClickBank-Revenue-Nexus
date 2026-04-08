import json
import sqlite3
from flask import Flask, jsonify
from flask_cors import CORS

# 1. Load User Configuration
with open('config.json', 'r') as f:
    config = json.load(f)

app = Flask(__name__)
CORS(app)

def get_db_connection():
    # Uses the DB name from config.json
    conn = sqlite3.connect(config['database']['db_name'])
    conn.row_factory = sqlite3.Row
    return conn

@app.route('/api/place-ad', methods=['POST'])
def place_ad():
    """Deterministic Ad Placement Logic"""
    # In a pro version, this would trigger your bridge page scripts
    return jsonify({"status": "success", "msg": "Deterministic Ad Deployed."})

@app.route('/api/get-revenue', methods=['GET'])
def get_revenue():
    """Syncs the Revenue Ticker with the Source of Truth"""
    try:
        conn = get_db_connection()
        # Summing the commission based on the user's schema
        query = 'SELECT SUM(commission_earned) as total FROM clickbank_nexus_revenue WHERE status="verified"'
        row = conn.execute(query).fetchone()
        conn.close()
        
        total = row['total'] if row['total'] else 0.00
        return jsonify({"total_revenue": float(total)})
    except Exception as e:
        return jsonify({"total_revenue": 0.00, "error": str(e)}), 500

if __name__ == "__main__":
    print(f"--- ClickBank Revenue Nexus v1.0.0 ---")
    print(f"Target Database: {config['database']['db_name']}")
    print(f"Engine running on port: {config['server']['port']}")
    
    app.run(
        port=config['server']['port'], 
        debug=config['server']['debug_mode']
    )
