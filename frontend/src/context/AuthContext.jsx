import { createContext, useContext, useEffect, useState } from "react";
import api from "../api/axios";

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => {
    const stored = localStorage.getItem("signalayiti_user");
    return stored ? JSON.parse(stored) : null;
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("signalayiti_token");
    if (!token) {
      setLoading(false);
      return;
    }
    api
      .get("/me")
      .then((res) => {
        setUser(res.data.data);
        localStorage.setItem("signalayiti_user", JSON.stringify(res.data.data));
      })
      .catch(() => {
        setUser(null);
      })
      .finally(() => setLoading(false));
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, []);

  function login(userData, token) {
    localStorage.setItem("signalayiti_token", token);
    localStorage.setItem("signalayiti_user", JSON.stringify(userData));
    setUser(userData);
  }

  async function logout() {
    try {
      await api.post("/logout");
    } catch {
      // on se deconnecte localement meme si la requete echoue
    }
    localStorage.removeItem("signalayiti_token");
    localStorage.removeItem("signalayiti_user");
    setUser(null);
  }

  return (
    <AuthContext.Provider value={{ user, login, logout, loading, isAgent: user?.role === "agent" }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  return useContext(AuthContext);
}
