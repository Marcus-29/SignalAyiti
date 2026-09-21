export const CATEGORIES = [
  { value: "route", label: "Route", icone: "🛣️" },
  { value: "eau", label: "Eau potable", icone: "💧" },
  { value: "electricite", label: "Électricité", icone: "⚡" },
  { value: "dechets", label: "Déchets", icone: "🗑️" },
  { value: "eclairage", label: "Éclairage public", icone: "💡" },
  { value: "securite", label: "Sécurité", icone: "🚨" },
  { value: "autre", label: "Autre", icone: "📌" },
];

export function categorieLabel(value) {
  return CATEGORIES.find((c) => c.value === value)?.label || value;
}

export function categorieIcone(value) {
  return CATEGORIES.find((c) => c.value === value)?.icone || "📌";
}

export const STATUTS = [
  { value: "nouveau", label: "Nouveau" },
  { value: "en_cours", label: "En cours" },
  { value: "resolu", label: "Résolu" },
  { value: "rejete", label: "Rejeté" },
];
