import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../api/axios";
import { useAuth } from "../context/AuthContext";
import StatCard from "../components/StatCard";

export default function HomePage() {
  const { user } = useAuth();
  const [stats, setStats] = useState(null);

  useEffect(() => {
    api
      .get("/stats/public")
      .then((res) => setStats(res.data))
      .catch(() => setStats(null));
  }, []);

  return (
    <div className="home-page">
      <section className="hero">
        <h1>Signalez les problemes de votre quartier</h1>
        <p>
          SignalAyiti permet aux citoyens de signaler facilement les routes endommagees, les
          coupures d'eau ou d'electricite, les dechets non ramasses et bien d'autres problemes,
          puis de suivre leur traitement par la commune.
        </p>
        <div className="hero-actions">
          <Link to={user ? "/signalements/nouveau" : "/inscription"} className="btn btn-primary">
            Signaler un probleme
          </Link>
          <Link to="/signalements" className="btn btn-ghost">
            Voir les signalements
          </Link>
        </div>
      </section>

      {stats && (
        <section className="stats-row">
          <StatCard label="Signalements resolus" value={stats.resolus} tone="resolu" />
          <StatCard label="Signalements en cours" value={stats.en_cours} tone="en_cours" />
          <StatCard label="Quartiers actifs" value={stats.quartiers_actifs} tone="default" />
        </section>
      )}

      <section className="steps">
        <div className="card step-card">
          <span className="step-number">1</span>
          <h3>Signaler</h3>
          <p>Decrivez le probleme observe dans votre quartier en quelques champs simples.</p>
        </div>
        <div className="card step-card">
          <span className="step-number">2</span>
          <h3>Suivre</h3>
          <p>Consultez a tout moment le statut de votre signalement et l'historique des interventions.</p>
        </div>
        <div className="card step-card">
          <span className="step-number">3</span>
          <h3>Etre notifie</h3>
          <p>Recevez une notification des que la commune met a jour votre signalement.</p>
        </div>
      </section>
    </div>
  );
}
