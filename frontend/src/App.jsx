import { Route, Routes } from "react-router-dom";
import Navbar from "./components/Navbar";
import Footer from "./components/Footer";
import ProtectedRoute from "./components/ProtectedRoute";
import HomePage from "./pages/HomePage";
import LoginPage from "./pages/LoginPage";
import RegisterPage from "./pages/RegisterPage";
import SignalementsListPage from "./pages/SignalementsListPage";
import NewSignalementPage from "./pages/NewSignalementPage";
import SignalementDetailPage from "./pages/SignalementDetailPage";
import DashboardPage from "./pages/DashboardPage";
import NotificationsPage from "./pages/NotificationsPage";

export default function App() {
  return (
    <div className="app-shell">
      <Navbar />
      <main className="app-content">
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/connexion" element={<LoginPage />} />
          <Route path="/inscription" element={<RegisterPage />} />
          <Route
            path="/signalements"
            element={
              <ProtectedRoute>
                <SignalementsListPage />
              </ProtectedRoute>
            }
          />
          <Route
            path="/signalements/nouveau"
            element={
              <ProtectedRoute>
                <NewSignalementPage />
              </ProtectedRoute>
            }
          />
          <Route
            path="/signalements/:id"
            element={
              <ProtectedRoute>
                <SignalementDetailPage />
              </ProtectedRoute>
            }
          />
          <Route
            path="/tableau-de-bord"
            element={
              <ProtectedRoute agentOnly>
                <DashboardPage />
              </ProtectedRoute>
            }
          />
          <Route
            path="/notifications"
            element={
              <ProtectedRoute>
                <NotificationsPage />
              </ProtectedRoute>
            }
          />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}
