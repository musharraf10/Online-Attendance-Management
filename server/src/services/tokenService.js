import jwt from 'jsonwebtoken';
import { env } from '../config/env.js';

export const createAccessToken = (payload) =>
  jwt.sign(payload, env.jwtSecret, { expiresIn: env.jwtExpiresIn });
