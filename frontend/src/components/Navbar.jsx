import { Link, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

export default function Navbar() {
  const { user, logout, isAgent } = useAuth();
  const navigate = useNavigate();

  async function handleLogout() {
    await logout();
    navigate("/connexion");
  }

  return (
    <header className="navbar">
      <div className="navbar-inner">
        <Link to="/" className="navbar-brand">
          <span className="navbar-logo" aria-hidden="true">
            🇭🇹
          </span>
          SignalAyiti
        </Link>
        <nav className="navbar-links">
          {user ? (
            <>
              <Link to="/signalements/nouveau">Signaler un probleme</Link>
              <Link to="/signalements">{isAgent ? "Tous les signalements" : "Mes signalements"}</Link>
              {isAgent && <Link to="/tableau-de-bord">Tableau de bord</Link>}
              <Link to="/notifications">Notifications</Link>
              <span className="navbar-user">{user.name}</span>
              <button type="button" className="btn btn-ghost" onClick={handleLogout}>
                Deconnexion
              </button>
            </>
          ) : (
            <>
              <Link to="/connexion">Connexion</Link>
              <Link to="/inscription" className="btn btn-primary btn-sm">
                Creer un compte
              </Link>
            </>
          )}
        </nav>
      </div>
    </header>
  );
}
