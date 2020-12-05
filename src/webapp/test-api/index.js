const express = require('express');
const cors = require('cors');
const app = express();

const corsOptions = {
    origin: [
        'http://localhost',
        'http://localhost:8086',
    ],
    methods: ['PUT', 'POST', 'DELETE'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    credentials: true,
    optionsSuccessStatus: 200,
};

app.use(cors(corsOptions));

const statusOK = (req, res) => res.json({});

app.use((req, res, next) => {
    console.log(req.originalUrl);
    return next();
});

app.post('/api/flight', statusOK);

const kPort = 3003;
app.listen(kPort, () => {
    console.log(`Server is running on port ${kPort}`);
});
