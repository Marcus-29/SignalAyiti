const LABELS = {
  nouveau: "Nouveau",
  en_cours: "En cours",
  resolu: "Résolu",
  rejete: "Rejeté",
};

export default function StatutBadge({ statut }) {
  return <span className={`badge badge-${statut}`}>{LABELS[statut] || statut}</span>;
}
