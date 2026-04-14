import { useState } from 'react';
import { useApp } from '../context/AppContext';
import { useNavigate } from 'react-router-dom';
import { Plus, Search, Filter } from 'lucide-react';
import StatusBadge from '../components/StatusBadge';
import { formatDate } from '../utils/format';
import { TicketStatus } from '../data/types';

export default function TicketsList() {
  const { tickets, clients, collaborators } = useApp();
  const navigate = useNavigate();
  const [searchTerm, setSearchTerm] = useState('');
  const [statusFilter, setStatusFilter] = useState<TicketStatus[]>([]);
  const [collaboratorFilter, setCollaboratorFilter] = useState('');
  const [clientFilter, setClientFilter] = useState('');

  const filteredTickets = tickets.filter(ticket => {
    const client = clients.find(c => c.id === ticket.clientId);
    const collaborator = collaborators.find(c => c.id === ticket.primaryCollaboratorId);

    const matchesSearch =
      searchTerm === '' ||
      ticket.id.includes(searchTerm) ||
      ticket.description.toLowerCase().includes(searchTerm.toLowerCase());

    const matchesStatus = statusFilter.length === 0 || statusFilter.includes(ticket.status);
    const matchesCollaborator = collaboratorFilter === '' || ticket.primaryCollaboratorId === collaboratorFilter;
    const matchesClient = clientFilter === '' || ticket.clientId === clientFilter;

    return matchesSearch && matchesStatus && matchesCollaborator && matchesClient;
  });

  const toggleStatusFilter = (status: TicketStatus) => {
    setStatusFilter(prev =>
      prev.includes(status) ? prev.filter(s => s !== status) : [...prev, status]
    );
  };

  const statuses: TicketStatus[] = ['open', 'in_progress', 'awaiting_client', 'resolved', 'closed', 'cancelled'];

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-3xl">Tickets</h1>
        <button
          onClick={() => navigate('/tickets/new')}
          className="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
        >
          <Plus className="w-5 h-5" />
          New Ticket
        </button>
      </div>

      <div className="bg-white p-4 rounded-lg border border-slate-200 shadow-sm space-y-4">
        <div className="flex items-center gap-3">
          <Filter className="w-5 h-5 text-slate-400" />
          <span className="text-sm">Filters</span>
        </div>

        <div className="flex flex-wrap gap-2">
          {statuses.map(status => (
            <button
              key={status}
              onClick={() => toggleStatusFilter(status)}
              className={`px-3 py-1.5 rounded-md text-sm border transition-colors ${
                statusFilter.includes(status)
                  ? 'bg-indigo-100 border-indigo-300 text-indigo-700'
                  : 'bg-white border-slate-300 text-slate-700 hover:bg-slate-50'
              }`}
            >
              <StatusBadge status={status} />
            </button>
          ))}
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div className="relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
            <input
              type="text"
              placeholder="Search by ID or description..."
              value={searchTerm}
              onChange={e => setSearchTerm(e.target.value)}
              className="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <select
            value={collaboratorFilter}
            onChange={e => setCollaboratorFilter(e.target.value)}
            className="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option value="">All Collaborators</option>
            {collaborators.map(c => (
              <option key={c.id} value={c.id}>{c.name}</option>
            ))}
          </select>

          <select
            value={clientFilter}
            onChange={e => setClientFilter(e.target.value)}
            className="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option value="">All Clients</option>
            {clients.map(c => (
              <option key={c.id} value={c.id}>{c.name}</option>
            ))}
          </select>
        </div>

        {(searchTerm || statusFilter.length > 0 || collaboratorFilter || clientFilter) && (
          <button
            onClick={() => {
              setSearchTerm('');
              setStatusFilter([]);
              setCollaboratorFilter('');
              setClientFilter('');
            }}
            className="text-sm text-indigo-600 hover:text-indigo-700"
          >
            Clear all filters
          </button>
        )}
      </div>

      <div className="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-slate-50 border-b border-slate-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">ID</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Status</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Client</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Description</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Collaborator</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Opening Date</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Scheduled</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-200">
              {filteredTickets.length === 0 ? (
                <tr>
                  <td colSpan={7} className="px-6 py-12 text-center text-slate-500">
                    No tickets found. Try adjusting your filters.
                  </td>
                </tr>
              ) : (
                filteredTickets.map(ticket => {
                  const client = clients.find(c => c.id === ticket.clientId);
                  const collaborator = collaborators.find(c => c.id === ticket.primaryCollaboratorId);
                  const isOverdue =
                    (ticket.status !== 'resolved' && ticket.status !== 'closed' && ticket.status !== 'cancelled') &&
                    new Date(ticket.scheduledStart) < new Date();

                  return (
                    <tr
                      key={ticket.id}
                      onClick={() => navigate(`/tickets/${ticket.id}`)}
                      className={`hover:bg-slate-50 cursor-pointer ${
                        isOverdue ? 'border-l-4 border-l-red-500' : ''
                      }`}
                    >
                      <td className="px-6 py-4 text-sm">#{ticket.id}</td>
                      <td className="px-6 py-4">
                        <StatusBadge status={ticket.status} />
                      </td>
                      <td className="px-6 py-4 text-sm">{client?.name}</td>
                      <td className="px-6 py-4 text-sm max-w-md truncate">{ticket.description}</td>
                      <td className="px-6 py-4 text-sm">{collaborator?.name}</td>
                      <td className="px-6 py-4 text-sm">{formatDate(ticket.openingDate)}</td>
                      <td className="px-6 py-4 text-sm">
                        {formatDate(ticket.scheduledStart)}
                        {isOverdue && <span className="ml-2 text-red-600">⚠ Overdue</span>}
                      </td>
                    </tr>
                  );
                })
              )}
            </tbody>
          </table>
        </div>
      </div>

      <div className="text-sm text-slate-600">
        Showing {filteredTickets.length} of {tickets.length} tickets
      </div>
    </div>
  );
}
