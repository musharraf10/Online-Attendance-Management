import { dbPool } from '../../db/pool.js';
import { ApiError } from '../../utils/apiError.js';
import { createAccessToken } from '../../services/tokenService.js';

export const login = async (req, res, next) => {
  try {
    const { username, password } = req.body;

    if (!username || !password) {
      throw new ApiError(400, 'Username and password are required');
    }

    const [rows] = await dbPool.execute(
      'SELECT id, username, role FROM users WHERE username = ? AND password = ? LIMIT 1',
      [username, password]
    );

    const user = rows[0];

    if (!user) {
      throw new ApiError(401, 'Invalid credentials');
    }

    const token = createAccessToken({
      id: user.id,
      username: user.username,
      role: user.role
    });

    res.json({
      success: true,
      token,
      user
    });
  } catch (error) {
    next(error);
  }
};
