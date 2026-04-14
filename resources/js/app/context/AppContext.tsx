import React, { createContext, useContext, useState, useEffect, ReactNode } from 'react';
import axios from 'axios';
import api from '../../lib/api';
import type { User, Collaborator, Client, Ticket } from '../data/types';

interface AppContextType {
  currentUser: User | null;
  users: User[];
  collaborators: Collaborator[];
  clients: Client[];
  tickets: Ticket[];
  loading: boolean;
  addTicket: (ticket: Omit<Ticket, 'id' | 'createdAt'>) => Promise<void>;
  updateTicket: (id: string, updates: Partial<Ticket>) => Promise<void>;
  deleteTicket: (id: string) => Promise<void>;
  addClient: (client: Omit<Client, 'id'>) => Promise<void>;
  updateClient: (id: string, updates: Partial<Client>) => Promise<void>;
  deleteClient: (id: string) => Promise<void>;
  addCollaborator: (collaborator: Omit<Collaborator, 'id'>) => Promise<void>;
  updateCollaborator: (id: string, updates: Partial<Collaborator>) => Promise<void>;
  deleteCollaborator: (id: string) => Promise<void>;
  addUser: (user: { name: string; email: string; password: string }) => Promise<void>;
  updateUser: (id: string, updates: { name?: string; email?: string; password?: string }) => Promise<void>;
  deleteUser: (id: string) => Promise<void>;
}

const AppContext = createContext<AppContextType | undefined>(undefined);

export const AppProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
  const [currentUser, setCurrentUser] = useState<User | null>(null);
  const [users, setUsers] = useState<User[]>([]);
  const [collaborators, setCollaborators] = useState<Collaborator[]>([]);
  const [clients, setClients] = useState<Client[]>([]);
  const [tickets, setTickets] = useState<Ticket[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Initialize Sanctum session auth for API requests before fetching data.
    axios.get('/sanctum/csrf-cookie', { withCredentials: true })
      .then(() => Promise.all([
        api.get('/user'),
        api.get('/supports'),
        api.get('/clients'),
        api.get('/collaborators'),
      ]))
      .then(([userRes, supportsRes, clientsRes, collabsRes]) => {
        setCurrentUser(userRes.data);
        setTickets(supportsRes.data.data ?? []);
        setClients(clientsRes.data.data ?? []);
        setCollaborators(collabsRes.data.data ?? []);
      })
      .finally(() => setLoading(false));
  }, []);

  // ── Tickets ────────────────────────────────────────────────────────────────

  const addTicket = async (ticket: Omit<Ticket, 'id' | 'createdAt'>) => {
    const res = await api.post('/supports', ticket);
    setTickets((prev) => [...prev, res.data.data]);
  };

  const updateTicket = async (id: string, updates: Partial<Ticket>) => {
    const res = await api.put(`/supports/${id}`, updates);
    setTickets((prev) => prev.map((t) => (t.id === id ? res.data.data : t)));
  };

  const deleteTicket = async (id: string) => {
    await api.delete(`/supports/${id}`);
    setTickets((prev) => prev.filter((t) => t.id !== id));
  };

  // ── Clients ────────────────────────────────────────────────────────────────

  const addClient = async (client: Omit<Client, 'id'>) => {
    const res = await api.post('/clients', client);
    setClients((prev) => [...prev, res.data.data]);
  };

  const updateClient = async (id: string, updates: Partial<Client>) => {
    const res = await api.put(`/clients/${id}`, updates);
    setClients((prev) => prev.map((c) => (c.id === id ? res.data.data : c)));
  };

  const deleteClient = async (id: string) => {
    await api.delete(`/clients/${id}`);
    setClients((prev) => prev.filter((c) => c.id !== id));
  };

  // ── Collaborators ──────────────────────────────────────────────────────────

  const addCollaborator = async (collaborator: Omit<Collaborator, 'id'>) => {
    const res = await api.post('/collaborators', collaborator);
    setCollaborators((prev) => [...prev, res.data.data]);
  };

  const updateCollaborator = async (id: string, updates: Partial<Collaborator>) => {
    const res = await api.put(`/collaborators/${id}`, updates);
    setCollaborators((prev) => prev.map((c) => (c.id === id ? res.data.data : c)));
  };

  const deleteCollaborator = async (id: string) => {
    await api.delete(`/collaborators/${id}`);
    setCollaborators((prev) => prev.filter((c) => c.id !== id));
  };

  // ── Users ──────────────────────────────────────────────────────────────────

  const addUser = async (user: { name: string; email: string; password: string }) => {
    const res = await api.post('/users', user);
    setUsers((prev) => [...prev, res.data.data]);
  };

  const updateUser = async (id: string, updates: { name?: string; email?: string; password?: string }) => {
    const res = await api.put(`/users/${id}`, updates);
    setUsers((prev) => prev.map((u) => (u.id === id ? res.data.data : u)));
  };

  const deleteUser = async (id: string) => {
    await api.delete(`/users/${id}`);
    setUsers((prev) => prev.filter((u) => u.id !== id));
  };

  return (
    <AppContext.Provider
      value={{
        currentUser,
        users,
        collaborators,
        clients,
        tickets,
        loading,
        addTicket,
        updateTicket,
        deleteTicket,
        addClient,
        updateClient,
        deleteClient,
        addCollaborator,
        updateCollaborator,
        deleteCollaborator,
        addUser,
        updateUser,
        deleteUser,
      }}
    >
      {children}
    </AppContext.Provider>
  );
};

export const useApp = () => {
  const context = useContext(AppContext);
  if (context === undefined) {
    throw new Error('useApp must be used within an AppProvider');
  }
  return context;
};
