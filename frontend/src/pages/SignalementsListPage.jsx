import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../api/axios";
import { useAuth } from "../context/AuthContext";
import SignalementCard from "../components/SignalementCard";
import { CATEGORIES, STATUTS } from "../components/categories";

export default function SignalementsListPage() {
  const { isAgent } = useAuth();
  const [signalements, setSignalements] = useState([]);
  const [meta, setMeta] = useState(null);
  const [page, setPage] = useState(1);
  const [filtres, setFiltres] = useState({ statut: "", categorie: "", quartier: "" });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    setLoading(true);
    const params = { page, ...filtres };
    Object.keys(params).forEach((key) => !params[key] && delete params[key]);

    api
      .get("/signalements", { params })
      .then((res) => {
        setSignalements(res.data.data);
        setMeta(res.data.meta);
        setError(null);
      })
      .catch(() => setError("Impossible de charger les signalements."))
      .finally(() => setLoading(false));
  }, [page, filtres]);

  function updateFiltre(field) {
    return (e) => {
      setPage(1);
      setFiltres({ ...filtres, [field]: e.target.value });
    };
  }

  return (
    <div className="list-page">
      <div className="list-page-header">
        <h1>{isAgent ? "Tous les signalements" : "Mes signalements"}</h1>
        <Link to="/signalements/nouveau" className="btn btn-primary">
          Nouveau signalement
        </Link>
      </div>

      <div className="filters">
        <select value={filtres.statut} onChange={updateFiltre("statut")}>
          <option value="">Tous les statuts</option>
          {STATUTS.map((s) => (
            <option key={s.value} value={s.value}>
              {s.label}
            </option>
          ))}
        </select>
        <select value={filtres.categorie} onChange={updateFiltre("categorie")}>
          <option value="">Toutes les categories</option>
          {CATEGORIES.map((c) => (
            <option key={c.value} value={c.value}>
              {c.label}
            </option>
          ))}
        </select>
        <input
          placeholder="Filtrer par quartier"
          value={filtres.quartier}
          onChange={updateFiltre("quartier")}
        />
      </div>

      {loading && <p className="page-loading">Chargement des signalements...</p>}
      {error && <p className="form-error">{error}</p>}

      {!loading && !error && signalements.length === 0 && (
        <p className="muted">Aucun signalement ne correspond a ces criteres pour le moment.</p>
      )}

      <div className="signalement-list">
        {signalements.map((s) => (
          <SignalementCard key={s.id} signalement={s} />
        ))}
      </div>

      {meta && meta.last_page > 1 && (
        <div className="pagination">
          <button disabled={page <= 1} onClick={() => setPage((p) => p - 1)} className="btn btn-ghost">
            Page precedente
          </button>
          <span className="muted">
            Page {meta.current_page} sur {meta.last_page}
          </span>
          <button
            disabled={page >= meta.last_page}
            onClick={() => setPage((p) => p + 1)}
            className="btn btn-ghost"
          >
            Page suivante
          </button>
        </div>
      )}
    </div>
  );
}
