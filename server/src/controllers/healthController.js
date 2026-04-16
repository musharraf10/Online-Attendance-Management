export const healthCheck = (_req, res) => {
  res.json({ success: true, message: 'API is running' });
};
