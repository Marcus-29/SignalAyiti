import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "http://127.0.0.1:8000/api",
  headers: {
    Accept: "application/json",
  },
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("signalayiti_token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      localStorage.removeItem("signalayiti_token");
      localStorage.removeItem("signalayiti_user");
      if (!window.location.pathname.startsWith("/connexion")) {
        window.location.href = "/connexion";
      }
    }
    return Promise.reject(error);
  }
);

export default api;
