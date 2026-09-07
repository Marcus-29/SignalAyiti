import StatutBadge from "./StatutBadge";

export default function InterventionTimeline({ interventions }) {
  if (!interventions || interventions.length === 0) {
    return <p className="muted">Aucune intervention pour le moment.</p>;
  }

  return (
    <ul className="timeline">
      {interventions.map((intervention) => (
        <li key={intervention.id} className="timeline-item">
          <div className="timeline-marker" />
          <div className="timeline-content">
            <div className="timeline-statuts">
              <StatutBadge statut={intervention.ancien_statut} />
              <span className="timeline-arrow"> vers </span>
              <StatutBadge statut={intervention.nouveau_statut} />
            </div>
            {intervention.commentaire && <p>{intervention.commentaire}</p>}
            <p className="muted timeline-meta">
              {intervention.agent ? `Par ${intervention.agent}, ` : ""}
              {new Date(intervention.created_at).toLocaleString("fr-FR")}
            </p>
          </div>
        </li>
      ))}
    </ul>
  );
}
