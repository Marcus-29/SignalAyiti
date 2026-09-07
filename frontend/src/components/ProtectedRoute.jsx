import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

export default function ProtectedRoute({ children, agentOnly = false }) {
  const { user, loading, isAgent } = useAuth();

  if (loading) {
    return <p className="page-loading">Chargement...</p>;
  }

  if (!user) {
    return <Navigate to="/connexion" replace />;
  }

  if (agentOnly && !isAgent) {
    return <Navigate to="/" replace />;
  }

  return children;
}
