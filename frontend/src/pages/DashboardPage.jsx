import { useEffect, useState } from "react";
import api from "../api/axios";
import StatCard from "../components/StatCard";
import { categorieLabel } from "../components/categories";

export default function DashboardPage() {
  const [stats, setStats] = useState(null);
  const [error, setError] = useState(null);

  useEffect(() => {
    api
      .get("/dashboard/stats")
      .then((res) => setStats(res.data))
      .catch(() => setError("Impossible de charger les statistiques."));
  }, []);

  if (error) return <p className="form-error">{error}</p>;
  if (!stats) return <p className="page-loading">Chargement du tableau de bord...</p>;

  return (
    <div className="dashboard-page">
      <h1>Tableau de bord</h1>

      <section className="stats-row">
        <StatCard label="Nouveaux" value={stats.par_statut.nouveau || 0} tone="nouveau" />
        <StatCard label="En cours" value={stats.par_statut.en_cours || 0} tone="en_cours" />
        <StatCard label="Resolus" value={stats.par_statut.resolu || 0} tone="resolu" />
        <StatCard label="Rejetes" value={stats.par_statut.rejete || 0} tone="rejete" />
      </section>

      <div className="dashboard-columns">
        <div className="card">
          <h2>Par categorie</h2>
          <ul className="stat-list">
            {Object.entries(stats.par_categorie).map(([categorie, total]) => (
              <li key={categorie}>
                <span>{categorieLabel(categorie)}</span>
                <div className="stat-bar-track">
                  <div
                    className="stat-bar-fill"
                    style={{ width: `${Math.min(100, (total / stats.total) * 100)}%` }}
                  />
                </div>
                <span className="muted">{total}</span>
              </li>
            ))}
          </ul>
        </div>

        <div className="card">
          <h2>Par quartier</h2>
          <table className="simple-table">
            <thead>
              <tr>
                <th>Quartier</th>
                <th>Signalements</th>
              </tr>
            </thead>
            <tbody>
              {Object.entries(stats.par_quartier).map(([quartier, total]) => (
                <tr key={quartier}>
                  <td>{quartier}</td>
                  <td>{total}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
