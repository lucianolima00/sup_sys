import { useParams, useNavigate } from 'react-router-dom';
import { useApp } from '../context/AppContext';
import { ArrowLeft, Edit, MapPin, User, Calendar, Clock } from 'lucide-react';
import StatusBadge from '../components/StatusBadge';
import { formatDate, formatDateTime, formatAddress } from '../utils/format';
import { TicketStatus } from '../data/types';
import { useState } from 'react';

export default function TicketDetail() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const { tickets, clients, collaborators, users, updateTicket } = useApp();
  const [showStatusMenu, setShowStatusMenu] = useState(false);

  const ticket = tickets.find(t => t.id === id);

  if (!ticket) {
    return (
      <div className="p-8">
        <div className="text-center py-12">
          <p className="text-slate-600">Ticket not found</p>
          <button
            onClick={() => navigate('/tickets')}
            className="mt-4 text-indigo-600 hover:text-indigo-700"
          >
            Back to tickets
          </button>
        </div>
      </div>
    );
  }

  const client = clients.find(c => c.id === ticket.clientId);
  const primaryCollaborator = collaborators.find(c => c.id === ticket.primaryCollaboratorId);
  const secondaryCollaborator = ticket.secondaryCollaboratorId
    ? collaborators.find(c => c.id === ticket.secondaryCollaboratorId)
    : null;
  const requester = users.find(u => u.id === ticket.requesterId);

  const address = ticket.addressOverride || client;

  const handleStatusChange = (newStatus: TicketStatus) => {
    updateTicket(ticket.id, { status: newStatus });
    setShowStatusMenu(false);
  };

  const statuses: TicketStatus[] = ['open', 'in_progress', 'awaiting_client', 'resolved', 'closed', 'cancelled'];

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center gap-4">
        <button
          onClick={() => navigate('/tickets')}
          className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
        >
          <ArrowLeft className="w-5 h-5" />
        </button>
        <h1 className="text-3xl flex-1">Ticket #{ticket.id}</h1>
        <button
          onClick={() => navigate(`/tickets/${ticket.id}/edit`)}
          className="flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
        >
          <Edit className="w-4 h-4" />
          Edit
        </button>
      </div>

      <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
        <div className="flex items-center gap-4 mb-6">
          <div className="relative">
            <button
              onClick={() => setShowStatusMenu(!showStatusMenu)}
              className="hover:opacity-80 transition-opacity"
            >
              <StatusBadge status={ticket.status} className="text-sm px-4 py-2" />
            </button>
            {showStatusMenu && (
              <div className="absolute top-full left-0 mt-2 bg-white border border-slate-200 rounded-lg shadow-lg p-2 z-10 min-w-[200px]">
                {statuses.map(status => (
                  <button
                    key={status}
                    onClick={() => handleStatusChange(status)}
                    className="w-full text-left px-3 py-2 hover:bg-slate-50 rounded-md"
                  >
                    <StatusBadge status={status} />
                  </button>
                ))}
              </div>
            )}
          </div>
          <div className="flex items-center gap-2 text-sm text-slate-600">
            <Calendar className="w-4 h-4" />
            Opened {formatDate(ticket.openingDate)}
          </div>
          <div className="flex items-center gap-2 text-sm text-slate-600">
            <Clock className="w-4 h-4" />
            Created {formatDateTime(ticket.createdAt)}
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div className="lg:col-span-2 space-y-6">
            <div>
              <h2 className="text-sm uppercase text-slate-600 mb-2">Description</h2>
              <div className="bg-slate-50 p-4 rounded-lg">
                <p className="text-slate-800 whitespace-pre-wrap">{ticket.description}</p>
              </div>
            </div>

            {(ticket.status === 'resolved' || ticket.status === 'closed' || ticket.solution) && (
              <div>
                <h2 className="text-sm uppercase text-slate-600 mb-2">Solution</h2>
                <div className="bg-emerald-50 p-4 rounded-lg border border-emerald-200">
                  {ticket.solution ? (
                    <p className="text-slate-800 whitespace-pre-wrap">{ticket.solution}</p>
                  ) : (
                    <p className="text-slate-500 italic">No solution provided yet</p>
                  )}
                </div>
              </div>
            )}
          </div>

          <div className="space-y-4">
            <div className="bg-slate-50 p-4 rounded-lg">
              <h3 className="text-sm uppercase text-slate-600 mb-3 flex items-center gap-2">
                <User className="w-4 h-4" />
                Client
              </h3>
              {client && (
                <div className="space-y-2">
                  <button
                    onClick={() => navigate(`/clients/${client.id}`)}
                    className="hover:text-indigo-600 transition-colors"
                  >
                    <p className="text-sm">{client.name}</p>
                  </button>
                  <p className="text-sm text-slate-600">{client.companyName}</p>
                  <p className="text-sm text-slate-600">{client.phone}</p>
                  <p className="text-sm text-slate-600">{client.email}</p>
                </div>
              )}
            </div>

            <div className="bg-slate-50 p-4 rounded-lg">
              <h3 className="text-sm uppercase text-slate-600 mb-3 flex items-center gap-2">
                <MapPin className="w-4 h-4" />
                Address
              </h3>
              {address && (
                <p className="text-sm text-slate-800">{formatAddress(address)}</p>
              )}
            </div>

            <div className="bg-slate-50 p-4 rounded-lg">
              <h3 className="text-sm uppercase text-slate-600 mb-3">Assignment</h3>
              <div className="space-y-3">
                <div>
                  <p className="text-xs text-slate-500 mb-1">Primary Collaborator</p>
                  <div className="flex items-center gap-2">
                    <div className="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm">
                      {primaryCollaborator?.name.charAt(0)}
                    </div>
                    <div>
                      <p className="text-sm">{primaryCollaborator?.name}</p>
                      <p className="text-xs text-slate-600 capitalize">{primaryCollaborator?.type}</p>
                    </div>
                  </div>
                </div>
                {secondaryCollaborator && (
                  <div>
                    <p className="text-xs text-slate-500 mb-1">Secondary Collaborator</p>
                    <div className="flex items-center gap-2">
                      <div className="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center text-sm">
                        {secondaryCollaborator.name.charAt(0)}
                      </div>
                      <div>
                        <p className="text-sm">{secondaryCollaborator.name}</p>
                        <p className="text-xs text-slate-600 capitalize">{secondaryCollaborator.type}</p>
                      </div>
                    </div>
                  </div>
                )}
              </div>
            </div>

            <div className="bg-slate-50 p-4 rounded-lg">
              <h3 className="text-sm uppercase text-slate-600 mb-3">Dates</h3>
              <div className="space-y-2">
                <div>
                  <p className="text-xs text-slate-500">Opening Date</p>
                  <p className="text-sm">{formatDate(ticket.openingDate)}</p>
                </div>
                <div>
                  <p className="text-xs text-slate-500">Scheduled Start</p>
                  <p className="text-sm">{formatDateTime(ticket.scheduledStart)}</p>
                </div>
                <div>
                  <p className="text-xs text-slate-500">Created</p>
                  <p className="text-sm">{formatDateTime(ticket.createdAt)}</p>
                </div>
              </div>
            </div>

            <div className="bg-slate-50 p-4 rounded-lg">
              <h3 className="text-sm uppercase text-slate-600 mb-2">Requester</h3>
              <p className="text-sm">{requester?.name}</p>
              <p className="text-xs text-slate-600">{requester?.email}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
