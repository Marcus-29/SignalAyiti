import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import api from "../api/axios";
import { useAuth } from "../context/AuthContext";

export default function RegisterPage() {
  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    quartier: "",
    telephone: "",
  });
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const { login } = useAuth();
  const navigate = useNavigate();

  function update(field) {
    return (e) => setForm({ ...form, [field]: e.target.value });
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setErrors({});
    setLoading(true);
    try {
      const res = await api.post("/register", form);
      login(res.data.user, res.data.token);
      navigate("/signalements");
    } catch (err) {
      setErrors(err.response?.data?.errors || { general: ["Une erreur est survenue."] });
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="auth-page">
      <form className="card auth-card" onSubmit={handleSubmit}>
        <h1>Creer un compte citoyen</h1>
        {errors.general && <p className="form-error">{errors.general[0]}</p>}
        <label>
          Nom complet
          <input required value={form.name} onChange={update("name")} />
          {errors.name && <span className="field-error">{errors.name[0]}</span>}
        </label>
        <label>
          Adresse email
          <input type="email" required value={form.email} onChange={update("email")} />
          {errors.email && <span className="field-error">{errors.email[0]}</span>}
        </label>
        <label>
          Quartier
          <input value={form.quartier} onChange={update("quartier")} placeholder="Ex : Delmas 33" />
        </label>
        <label>
          Telephone (facultatif)
          <input value={form.telephone} onChange={update("telephone")} placeholder="+509 00 00 0000" />
        </label>
        <label>
          Mot de passe
          <input type="password" required value={form.password} onChange={update("password")} />
          {errors.password && <span className="field-error">{errors.password[0]}</span>}
        </label>
        <label>
          Confirmer le mot de passe
          <input
            type="password"
            required
            value={form.password_confirmation}
            onChange={update("password_confirmation")}
          />
        </label>
        <button type="submit" className="btn btn-primary" disabled={loading}>
          {loading ? "Creation..." : "Creer mon compte"}
        </button>
        <p className="muted">
          Deja un compte ? <Link to="/connexion">Connectez-vous</Link>
        </p>
      </form>
    </div>
  );
}
