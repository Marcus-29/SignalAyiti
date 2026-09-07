import { useState } from "react";
import { Link, useNavigate, useLocation } from "react-router-dom";
import api from "../api/axios";
import { useAuth } from "../context/AuthContext";

export default function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);
  const { login } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();

  async function handleSubmit(e) {
    e.preventDefault();
    setError(null);
    setLoading(true);
    try {
      const res = await api.post("/login", { email, password });
      login(res.data.user, res.data.token);
      navigate(location.state?.from || "/signalements");
    } catch (err) {
      setError(err.response?.data?.message || "Identifiants incorrects.");
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="auth-page">
      <form className="card auth-card" onSubmit={handleSubmit}>
        <h1>Se connecter</h1>
        {error && <p className="form-error">{error}</p>}
        <label>
          Adresse email
          <input type="email" required value={email} onChange={(e) => setEmail(e.target.value)} />
        </label>
        <label>
          Mot de passe
          <input type="password" required value={password} onChange={(e) => setPassword(e.target.value)} />
        </label>
        <button type="submit" className="btn btn-primary" disabled={loading}>
          {loading ? "Connexion..." : "Se connecter"}
        </button>
        <p className="muted">
          Pas encore de compte ? <Link to="/inscription">Inscrivez-vous</Link>
        </p>
        <p className="muted auth-demo">
          Compte de demonstration agent : agent@signalayiti.ht / password
        </p>
      </form>
    </div>
  );
}
