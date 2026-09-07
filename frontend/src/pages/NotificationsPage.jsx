import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../api/axios";

export default function NotificationsPage() {
  const [notifications, setNotifications] = useState([]);
  const [loading, setLoading] = useState(true);

  function charger() {
    setLoading(true);
    api
      .get("/notifications")
      .then((res) => setNotifications(res.data.data))
      .finally(() => setLoading(false));
  }

  useEffect(charger, []);

  async function marquerLue(id) {
    await api.put(`/notifications/${id}/lu`);
    charger();
  }

  return (
    <div className="list-page">
      <h1>Mes notifications</h1>
      {loading && <p className="page-loading">Chargement...</p>}
      {!loading && notifications.length === 0 && (
        <p className="muted">Vous n'avez pas encore de notification.</p>
      )}
      <ul className="notification-list">
        {notifications.map((n) => (
          <li key={n.id} className={`card notification-item ${n.lu ? "" : "notification-non-lue"}`}>
            <div>
              <p>{n.message}</p>
              <p className="muted">{new Date(n.created_at).toLocaleString("fr-FR")}</p>
            </div>
            <div className="notification-actions">
              <Link to={`/signalements/${n.signalement_id}`} className="btn btn-ghost btn-sm">
                Voir le signalement
              </Link>
              {!n.lu && (
                <button type="button" className="btn btn-sm" onClick={() => marquerLue(n.id)}>
                  Marquer comme lue
                </button>
              )}
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
}
