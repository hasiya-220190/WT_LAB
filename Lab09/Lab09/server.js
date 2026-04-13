const express = require("express");
const mysql = require("mysql");
const cors = require("cors");
const path = require("path");

const app = express();
app.use(cors());
app.use(express.json());

/* Serve images statically */
app.use("/images", express.static(path.join(__dirname, "images")));

const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "rastaurants"   // make sure spelling is correct
});

db.connect(err => {
    if (err) {
        console.error("DB connection failed:", err);
        return;
    }
    console.log("MySQL Connected");
});

/* API to get restaurants */
app.get("/restaurants", (req, res) => {
    const sql = "SELECT * FROM restaurants WHERE is_open = 1";
    db.query(sql, (err, result) => {
        if (err) {
            return res.status(500).json(err);
        }
        res.json(result);
    });
});

app.listen(3000, () => {
    console.log("Server running on http://localhost:3000");
});
