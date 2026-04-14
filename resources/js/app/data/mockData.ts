// Mock data for the support ticket system

export type TicketStatus = 'open' | 'in_progress' | 'awaiting_client' | 'resolved' | 'closed' | 'cancelled';

export type CollaboratorType = 'technician' | 'analyst' | 'manager';

export interface User {
  id: string;
  name: string;
  email: string;
  password: string;
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
  addressOverride?: {
    logradouro: string;
    numero: string;
    complemento: string;
    cep: string;
    bairro: string;
    cidade: string;
    estado: string;
  };
}

export const mockUsers: User[] = [
  { id: '1', name: 'Ana Silva', email: 'ana@suporte.com', password: 'senha123' },
  { id: '2', name: 'Carlos Santos', email: 'carlos@suporte.com', password: 'senha123' },
  { id: '3', name: 'Marina Costa', email: 'marina@suporte.com', password: 'senha123' },
];

export const mockCollaborators: Collaborator[] = [
  { id: '1', name: 'João Oliveira', cpfCnpj: '123.456.789-00', email: 'joao@tech.com', type: 'technician' },
  { id: '2', name: 'Paula Ferreira', cpfCnpj: '987.654.321-00', email: 'paula@tech.com', type: 'technician' },
  { id: '3', name: 'Roberto Lima', cpfCnpj: '456.789.123-00', email: 'roberto@tech.com', type: 'analyst' },
  { id: '4', name: 'Juliana Souza', cpfCnpj: '321.654.987-00', email: 'juliana@tech.com', type: 'manager' },
  { id: '5', name: 'Felipe Martins', cpfCnpj: '789.123.456-00', email: 'felipe@tech.com', type: 'technician' },
];

export const mockClients: Client[] = [
  {
    id: '1',
    name: 'Tech Solutions Ltda',
    companyName: 'Tech Solutions',
    cpfCnpj: '12.345.678/0001-00',
    email: 'contato@techsolutions.com',
    phone: '(11) 98765-4321',
    logradouro: 'Av. Paulista',
    numero: '1578',
    complemento: 'Sala 1201',
    cep: '01310-200',
    bairro: 'Bela Vista',
    cidade: 'São Paulo',
    estado: 'SP',
  },
  {
    id: '2',
    name: 'Maria Comercio ME',
    companyName: 'Maria Comercio',
    cpfCnpj: '98.765.432/0001-11',
    email: 'maria@comercio.com',
    phone: '(21) 91234-5678',
    logradouro: 'Rua das Flores',
    numero: '456',
    complemento: '',
    cep: '22041-020',
    bairro: 'Copacabana',
    cidade: 'Rio de Janeiro',
    estado: 'RJ',
  },
  {
    id: '3',
    name: 'Industria ABC S.A.',
    companyName: 'Industria ABC',
    cpfCnpj: '11.222.333/0001-44',
    email: 'contato@industriaabc.com',
    phone: '(19) 3456-7890',
    logradouro: 'Av. Industrial',
    numero: '2500',
    complemento: 'Galpão 5',
    cep: '13087-500',
    bairro: 'Distrito Industrial',
    cidade: 'Campinas',
    estado: 'SP',
  },
  {
    id: '4',
    name: 'Comércio Digital Ltda',
    companyName: 'Comércio Digital',
    cpfCnpj: '22.333.444/0001-55',
    email: 'suporte@comerciodigital.com',
    phone: '(31) 99876-5432',
    logradouro: 'Rua da Bahia',
    numero: '1234',
    complemento: 'Andar 8',
    cep: '30160-011',
    bairro: 'Centro',
    cidade: 'Belo Horizonte',
    estado: 'MG',
  },
];

export const mockTickets: Ticket[] = [
  {
    id: '1',
    status: 'open',
    clientId: '1',
    description: 'Sistema de ponto eletrônico não está registrando entradas corretamente. Funcionários relatam que ao bater o ponto, a marcação não aparece no sistema.',
    solution: '',
    primaryCollaboratorId: '1',
    requesterId: '1',
    openingDate: '2026-04-11',
    scheduledStart: '2026-04-12T09:00',
    createdAt: '2026-04-11T08:30:00',
  },
  {
    id: '2',
    status: 'in_progress',
    clientId: '2',
    description: 'Impressora fiscal apresentando erro E-15. Não conseguem emitir notas fiscais desde ontem à tarde.',
    solution: '',
    primaryCollaboratorId: '2',
    secondaryCollaboratorId: '3',
    requesterId: '2',
    openingDate: '2026-04-10',
    scheduledStart: '2026-04-11T14:00',
    createdAt: '2026-04-10T16:45:00',
  },
  {
    id: '3',
    status: 'awaiting_client',
    clientId: '3',
    description: 'Rede cabeada apresentando lentidão extrema. Ping alto e perda de pacotes em todos os computadores da produção.',
    solution: '',
    primaryCollaboratorId: '1',
    requesterId: '1',
    openingDate: '2026-04-09',
    scheduledStart: '2026-04-10T10:00',
    createdAt: '2026-04-09T14:20:00',
  },
  {
    id: '4',
    status: 'resolved',
    clientId: '1',
    description: 'Backup automático não está sendo executado há 3 dias. Sistema crítico precisa de backup diário.',
    solution: 'Script de backup estava com permissões incorretas. Corrigidas as permissões e reconfigurado o cron job. Backup testado e funcionando normalmente.',
    primaryCollaboratorId: '3',
    requesterId: '3',
    openingDate: '2026-04-08',
    scheduledStart: '2026-04-09T08:00',
    createdAt: '2026-04-08T11:15:00',
  },
  {
    id: '5',
    status: 'closed',
    clientId: '4',
    description: 'Instalação de nova estação de trabalho e configuração de acesso aos sistemas corporativos.',
    solution: 'Estação instalada com Windows 11 Pro, Office 365 configurado, VPN corporativa instalada e testada. Usuário treinado.',
    primaryCollaboratorId: '5',
    requesterId: '2',
    openingDate: '2026-04-05',
    scheduledStart: '2026-04-06T09:00',
    createdAt: '2026-04-05T10:00:00',
  },
  {
    id: '6',
    status: 'in_progress',
    clientId: '2',
    description: 'Servidor de e-mail com instabilidade. Mensagens não estão sendo enviadas e recebidas com frequência.',
    solution: '',
    primaryCollaboratorId: '4',
    secondaryCollaboratorId: '1',
    requesterId: '1',
    openingDate: '2026-04-11',
    scheduledStart: '2026-04-11T11:00',
    createdAt: '2026-04-11T09:00:00',
  },
  {
    id: '7',
    status: 'open',
    clientId: '3',
    description: 'Atualização do sistema ERP para nova versão. Necessário planejamento e execução em horário não comercial.',
    solution: '',
    primaryCollaboratorId: '3',
    secondaryCollaboratorId: '4',
    requesterId: '3',
    openingDate: '2026-04-10',
    scheduledStart: '2026-04-13T20:00',
    createdAt: '2026-04-10T13:30:00',
  },
  {
    id: '8',
    status: 'resolved',
    clientId: '4',
    description: 'Câmera de segurança do estacionamento sem imagem. Sistema de monitoramento mostrando offline.',
    solution: 'Cabo de rede danificado identificado e substituído. Câmera reconectada e funcionando normalmente.',
    primaryCollaboratorId: '2',
    requesterId: '2',
    openingDate: '2026-04-07',
    scheduledStart: '2026-04-08T15:00',
    createdAt: '2026-04-07T16:00:00',
  },
  {
    id: '9',
    status: 'open',
    clientId: '1',
    description: 'Solicitação de expansão da rede Wi-Fi para novo andar. Necessário estudo de cobertura e instalação de access points.',
    solution: '',
    primaryCollaboratorId: '5',
    requesterId: '1',
    openingDate: '2026-04-11',
    scheduledStart: '2026-04-15T09:00',
    createdAt: '2026-04-11T10:00:00',
  },
  {
    id: '10',
    status: 'cancelled',
    clientId: '2',
    description: 'Configuração de novo software de gestão. Cliente cancelou a implementação.',
    solution: '',
    primaryCollaboratorId: '3',
    requesterId: '3',
    openingDate: '2026-04-06',
    scheduledStart: '2026-04-08T14:00',
    createdAt: '2026-04-06T15:00:00',
  },
];
