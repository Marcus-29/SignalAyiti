import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../api/axios";
import { CATEGORIES } from "../components/categories";

export default function NewSignalementPage() {
  const [form, setForm] = useState({ categorie: "route", titre: "", description: "", quartier: "" });
  const [photo, setPhoto] = useState(null);
  const [errors, setErrors] = useState({});
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  function update(field) {
    return (e) => setForm({ ...form, [field]: e.target.value });
  }

  async function handleSubmit(e) {
    e.preventDefault();
    setErrors({});
    setLoading(true);

    const data = new FormData();
    Object.entries(form).forEach(([key, value]) => data.append(key, value));
    if (photo) data.append("photo", photo);

    try {
      const res = await api.post("/signalements", data, {
        headers: { "Content-Type": "multipart/form-data" },
      });
      navigate(`/signalements/${res.data.data.id}`);
    } catch (err) {
      setErrors(err.response?.data?.errors || { general: ["Une erreur est survenue."] });
    } finally {
      setLoading(false);
    }
  }

  return (
    <div className="form-page">
      <form className="card form-card" onSubmit={handleSubmit}>
        <h1>Signaler un probleme</h1>
        <p className="muted">
          Decrivez le probleme observe dans votre quartier. Plus votre description est precise,
          plus l'agent pourra intervenir rapidement.
        </p>
        {errors.general && <p className="form-error">{errors.general[0]}</p>}

        <label>
          Categorie
          <select value={form.categorie} onChange={update("categorie")}>
            {CATEGORIES.map((c) => (
              <option key={c.value} value={c.value}>
                {c.icone} {c.label}
              </option>
            ))}
          </select>
        </label>

        <label>
          Titre du signalement
          <input required value={form.titre} onChange={update("titre")} placeholder="Ex : Nid de poule rue principale" />
          {errors.titre && <span className="field-error">{errors.titre[0]}</span>}
        </label>

        <label>
          Description
          <textarea
            required
            rows={5}
            value={form.description}
            onChange={update("description")}
            placeholder="Decrivez le probleme, depuis quand il existe, sa gravite..."
          />
          {errors.description && <span className="field-error">{errors.description[0]}</span>}
        </label>

        <label>
          Quartier
          <input required value={form.quartier} onChange={update("quartier")} placeholder="Ex : Delmas 33" />
          {errors.quartier && <span className="field-error">{errors.quartier[0]}</span>}
        </label>

        <label>
          Photo (facultatif)
          <input type="file" accept="image/*" onChange={(e) => setPhoto(e.target.files[0])} />
          {errors.photo && <span className="field-error">{errors.photo[0]}</span>}
        </label>

        <button type="submit" className="btn btn-primary" disabled={loading}>
          {loading ? "Envoi..." : "Envoyer le signalement"}
        </button>
      </form>
    </div>
  );
}
