import { createRoot } from "react-dom/client";
import App from "./app/App.tsx";
import "./styles/index.css";
import axios from 'axios';

axios.defaults.withCredentials = true;
// @ts-ignore — withXSRFToken is available in axios 1.x but not always typed
axios.defaults.withXSRFToken = true;

createRoot(document.getElementById("root")!).render(<App />);
