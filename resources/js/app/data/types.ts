export type TicketStatus = 'open' | 'in_progress' | 'awaiting_client' | 'resolved' | 'closed' | 'cancelled';

export type CollaboratorType = 'technician' | 'analyst' | 'manager';

export interface User {
  id: string;
  name: string;
  email: string;
}

export interface Collaborator {
  id: string;
  name: string;
  cpfCnpj: string;
  email: string;
  type: CollaboratorType;
}

export interface Client {
  id: string;
  name: string;
  companyName: string;
  cpfCnpj: string;
  email: string;
  phone: string;
  logradouro: string;
  numero: string;
  complemento: string;
  cep: string;
  bairro: string;
  cidade: string;
  estado: string;
}

export interface Address {
  logradouro: string;
  numero: string;
  complemento: string;
  cep: string;
  bairro: string;
  cidade: string;
  estado: string;
}

export interface Ticket {
  id: string;
  status: TicketStatus;
  clientId: string;
  description: string;
  solution: string;
  primaryCollaboratorId: string;
  secondaryCollaboratorId?: string;
  requesterId: string;
  openingDate: string;
  scheduledStart: string;
  createdAt: string;
  addressOverride?: Address;
}
