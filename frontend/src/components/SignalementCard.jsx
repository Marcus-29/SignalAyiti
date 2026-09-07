import { Link } from "react-router-dom";
import StatutBadge from "./StatutBadge";
import { categorieIcone, categorieLabel } from "./categories";

export default function SignalementCard({ signalement }) {
  return (
    <Link to={`/signalements/${signalement.id}`} className="card signalement-card">
      <div className="signalement-card-header">
        <span className="signalement-icone" aria-hidden="true">
          {categorieIcone(signalement.categorie)}
        </span>
        <div>
          <h3>{signalement.titre}</h3>
          <p className="muted">
            {categorieLabel(signalement.categorie)} | {signalement.quartier}
          </p>
        </div>
        <StatutBadge statut={signalement.statut} />
      </div>
      <p className="signalement-description">{signalement.description}</p>
      <div className="signalement-card-footer">
        <span className="muted">
          {signalement.auteur ? `Signale par ${signalement.auteur}` : ""}
        </span>
        <time className="muted">
          {new Date(signalement.created_at).toLocaleDateString("fr-FR")}
        </time>
      </div>
    </Link>
  );
}
