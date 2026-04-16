import cors from 'cors';
import express from 'express';
import { env } from './config/env.js';
import routes from './routes/index.js';
import { errorHandler } from './middleware/errorHandler.js';

const app = express();

app.use(cors({ origin: env.clientOrigin }));
app.use(express.json());

app.use('/api', routes);
app.use(errorHandler);

app.listen(env.port, () => {
  console.log(`Server listening on port ${env.port}`);
});
