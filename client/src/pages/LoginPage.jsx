import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import { apiRequest } from '../services/api';

const LoginPage = () => {
  const navigate = useNavigate();
  const { login } = useAuth();
  const [formData, setFormData] = useState({ username: '', password: '' });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const onSubmit = async (event) => {
    event.preventDefault();
    setLoading(true);
    setError('');

    try {
      const data = await apiRequest('/auth/login', {
        method: 'POST',
        body: JSON.stringify(formData)
      });

      login(data.token, data.user);
      navigate('/dashboard');
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <main className="min-h-screen bg-slate-100 flex items-center justify-center p-4">
      <form onSubmit={onSubmit} className="w-full max-w-sm bg-white p-6 rounded-lg shadow">
        <h1 className="text-xl font-semibold mb-4">Login</h1>

        {error && <p className="text-red-600 text-sm mb-3">{error}</p>}

        <input
          className="w-full border rounded px-3 py-2 mb-3"
          placeholder="Username"
          value={formData.username}
          onChange={(event) =>
            setFormData((prev) => ({ ...prev, username: event.target.value }))
          }
        />

        <input
          className="w-full border rounded px-3 py-2 mb-4"
          type="password"
          placeholder="Password"
          value={formData.password}
          onChange={(event) =>
            setFormData((prev) => ({ ...prev, password: event.target.value }))
          }
        />

        <button
          className="w-full bg-blue-600 text-white rounded px-3 py-2 disabled:opacity-60"
          type="submit"
          disabled={loading}
        >
          {loading ? 'Signing in...' : 'Sign in'}
        </button>
      </form>
    </main>
  );
};

export default LoginPage;
