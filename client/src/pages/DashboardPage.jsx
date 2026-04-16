import { useAuth } from '../context/AuthContext';

const DashboardPage = () => {
  const { user, logout } = useAuth();

  return (
    <main className="min-h-screen bg-slate-100 p-6">
      <div className="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 className="text-2xl font-semibold mb-2">Dashboard</h1>
        <p className="mb-4">Welcome, {user?.username}</p>
        <button className="bg-slate-800 text-white rounded px-3 py-2" onClick={logout}>
          Logout
        </button>
      </div>
    </main>
  );
};

export default DashboardPage;
