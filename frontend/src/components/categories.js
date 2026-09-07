export const CATEGORIES = [
  { value: "route", label: "Route", icone: "🛣️" },
  { value: "eau", label: "Eau potable", icone: "💧" },
  { value: "electricite", label: "Electricite", icone: "⚡" },
  { value: "dechets", label: "Dechets", icone: "🗑️" },
  { value: "eclairage", label: "Eclairage public", icone: "💡" },
  { value: "securite", label: "Securite", icone: "🚨" },
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
  { value: "resolu", label: "Resolu" },
  { value: "rejete", label: "Rejete" },
];
