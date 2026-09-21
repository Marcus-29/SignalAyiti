import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import api from "../api/axios";
import { useAuth } from "../context/AuthContext";
import StatutBadge from "../components/StatutBadge";
import InterventionTimeline from "../components/InterventionTimeline";
import { categorieIcone, categorieLabel, STATUTS } from "../components/categories";

export default function SignalementDetailPage() {
  const { id } = useParams();
  const { user, isAgent } = useAuth();
  const navigate = useNavigate();

  const [signalement, setSignalement] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [nouveauStatut, setNouveauStatut] = useState("");
  const [commentaire, setCommentaire] = useState("");
  const [saving, setSaving] = useState(false);

  function charger() {
    setLoading(true);
    api
      .get(`/signalements/${id}`)
      .then((res) => {
        setSignalement(res.data.data);
        setNouveauStatut(res.data.data.statut);
        setError(null);
      })
      .catch(() => setError("Ce signalement est introuvable ou ne vous appartient pas."))
      .finally(() => setLoading(false));
  }

  useEffect(charger, [id]);

  async function handleIntervention(e) {
    e.preventDefault();
    setSaving(true);
    try {
      await api.put(`/signalements/${id}/statut`, { statut: nouveauStatut, commentaire });
      setCommentaire("");
      charger();
    } catch {
      setError("Impossible d'enregistrer l'intervention.");
    } finally {
      setSaving(false);
    }
  }

  async function handleDelete() {
    if (!window.confirm("Supprimer définitivement ce signalement ?")) return;
    await api.delete(`/signalements/${id}`);
    navigate("/signalements");
  }

  if (loading) return <p className="page-loading">Chargement...</p>;
  if (error) return <p className="form-error">{error}</p>;
  if (!signalement) return null;

  const peutSupprimer = isAgent || (signalement.user_id === user?.id && signalement.statut === "nouveau");

  return (
    <div className="detail-page">
      <div className="card detail-card">
        <div className="detail-header">
          <span className="signalement-icone-large" aria-hidden="true">
            {categorieIcone(signalement.categorie)}
          </span>
          <div>
            <h1>{signalement.titre}</h1>
            <p className="muted">
              {categorieLabel(signalement.categorie)} | {signalement.quartier}
            </p>
          </div>
          <StatutBadge statut={signalement.statut} />
        </div>

        <p className="detail-description">{signalement.description}</p>

        {signalement.photo_url && (
          <img src={signalement.photo_url} alt="Photo du problème signalé" className="detail-photo" />
        )}

        <p className="muted">
          Signalé par {signalement.auteur} le {new Date(signalement.created_at).toLocaleDateString("fr-FR")}
        </p>

        {peutSupprimer && (
          <button type="button" className="btn btn-danger" onClick={handleDelete}>
            Supprimer ce signalement
          </button>
        )}
      </div>

      <div className="card">
        <h2>Historique des interventions</h2>
        <InterventionTimeline interventions={signalement.interventions} />
      </div>

      {isAgent && (
        <form className="card" onSubmit={handleIntervention}>
          <h2>Ajouter une intervention</h2>
          <label>
            Nouveau statut
            <select value={nouveauStatut} onChange={(e) => setNouveauStatut(e.target.value)}>
              {STATUTS.map((s) => (
                <option key={s.value} value={s.value}>
                  {s.label}
                </option>
              ))}
            </select>
          </label>
          <label>
            Commentaire (facultatif)
            <textarea
              rows={3}
              value={commentaire}
              onChange={(e) => setCommentaire(e.target.value)}
              placeholder="Ex : une équipe technique a été envoyée sur place."
            />
          </label>
          <button type="submit" className="btn btn-primary" disabled={saving}>
            {saving ? "Enregistrement..." : "Enregistrer l'intervention"}
          </button>
        </form>
      )}
    </div>
  );
}
