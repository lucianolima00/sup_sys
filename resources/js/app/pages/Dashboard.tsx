import { useApp } from '../context/AppContext';
import { useNavigate } from 'react-router-dom';
import { Ticket, AlertCircle, CheckCircle, Clock, Plus } from 'lucide-react';
import StatusBadge from '../components/StatusBadge';
import { formatRelativeTime } from '../utils/format';
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, Legend } from 'recharts';

export default function Dashboard() {
  const { tickets, clients, collaborators } = useApp();
  const navigate = useNavigate();

  const openTickets = tickets.filter(t => t.status === 'open').length;
  const inProgressTickets = tickets.filter(t => t.status === 'in_progress').length;
  const resolvedToday = tickets.filter(t => {
    if (t.status !== 'resolved') return false;
    const today = new Date().toISOString().split('T')[0];
    return t.openingDate === today;
  }).length;

  const overdueTickets = tickets.filter(t => {
    if (t.status === 'resolved' || t.status === 'closed' || t.status === 'cancelled') return false;
    const scheduled = new Date(t.scheduledStart);
    return scheduled < new Date();
  }).length;

  const avgResolutionTime = '2.3 days';

  const last30DaysData = [
    { date: '11/03', opened: 3, resolved: 2 },
    { date: '14/03', opened: 5, resolved: 4 },
    { date: '17/03', opened: 2, resolved: 3 },
    { date: '20/03', opened: 4, resolved: 3 },
    { date: '23/03', opened: 6, resolved: 5 },
    { date: '26/03', opened: 3, resolved: 4 },
    { date: '29/03', opened: 4, resolved: 3 },
    { date: '01/04', opened: 5, resolved: 6 },
    { date: '04/04', opened: 3, resolved: 4 },
    { date: '07/04', opened: 4, resolved: 3 },
    { date: '10/04', opened: 5, resolved: 4 },
  ];

  const collaboratorStats = collaborators.map(c => {
    const assignedTickets = tickets.filter(t =>
      (t.primaryCollaboratorId === c.id || t.secondaryCollaboratorId === c.id) &&
      t.status !== 'closed' && t.status !== 'cancelled'
    ).length;
    return { name: c.name.split(' ')[0], tickets: assignedTickets };
  }).sort((a, b) => b.tickets - a.tickets).slice(0, 5);

  const recentTickets = [...tickets]
    .sort((a, b) => new Date(b.createdAt).getTime() - new Date(a.createdAt).getTime())
    .slice(0, 10);

  return (
    <div className="p-8 space-y-8">
      <div className="flex items-center justify-between">
        <h1 className="text-3xl">Dashboard</h1>
        <button
          onClick={() => navigate('/tickets/new')}
          className="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
        >
          <Plus className="w-5 h-5" />
          New Ticket
        </button>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <div className="flex items-center gap-3">
            <div className="p-3 bg-slate-100 rounded-lg">
              <Ticket className="w-6 h-6 text-slate-700" />
            </div>
            <div>
              <p className="text-sm text-slate-600">Open Tickets</p>
              <p className="text-2xl mt-1">{openTickets}</p>
            </div>
          </div>
        </div>

        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <div className="flex items-center gap-3">
            <div className="p-3 bg-amber-100 rounded-lg">
              <Clock className="w-6 h-6 text-amber-700" />
            </div>
            <div>
              <p className="text-sm text-slate-600">In Progress</p>
              <p className="text-2xl mt-1">{inProgressTickets}</p>
            </div>
          </div>
        </div>

        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <div className="flex items-center gap-3">
            <div className="p-3 bg-emerald-100 rounded-lg">
              <CheckCircle className="w-6 h-6 text-emerald-700" />
            </div>
            <div>
              <p className="text-sm text-slate-600">Resolved Today</p>
              <p className="text-2xl mt-1">{resolvedToday}</p>
            </div>
          </div>
        </div>

        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <div className="flex items-center gap-3">
            <div className="p-3 bg-blue-100 rounded-lg">
              <Clock className="w-6 h-6 text-blue-700" />
            </div>
            <div>
              <p className="text-sm text-slate-600">Avg Resolution</p>
              <p className="text-2xl mt-1">{avgResolutionTime}</p>
            </div>
          </div>
        </div>

        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <div className="flex items-center gap-3">
            <div className="p-3 bg-red-100 rounded-lg">
              <AlertCircle className="w-6 h-6 text-red-700" />
            </div>
            <div>
              <p className="text-sm text-slate-600">Overdue</p>
              <p className="text-2xl mt-1">{overdueTickets}</p>
            </div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <h2 className="text-lg mb-4">Tickets Opened vs Resolved (Last 30 Days)</h2>
          <ResponsiveContainer width="100%" height={250}>
            <BarChart data={last30DaysData}>
              <CartesianGrid strokeDasharray="3 3" />
              <XAxis dataKey="date" />
              <YAxis />
              <Tooltip />
              <Legend />
              <Bar dataKey="opened" fill="#6366f1" name="Opened" />
              <Bar dataKey="resolved" fill="#10b981" name="Resolved" />
            </BarChart>
          </ResponsiveContainer>
        </div>

        <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
          <h2 className="text-lg mb-4">Active Tickets by Collaborator</h2>
          <div className="space-y-3">
            {collaboratorStats.map((stat, index) => (
              <div key={index} className="flex items-center gap-3">
                <div className="flex-1">
                  <div className="flex items-center justify-between mb-1">
                    <span className="text-sm">{stat.name}</span>
                    <span className="text-sm">{stat.tickets}</span>
                  </div>
                  <div className="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div
                      className="h-full bg-indigo-600 rounded-full"
                      style={{ width: `${(stat.tickets / Math.max(...collaboratorStats.map(s => s.tickets))) * 100}%` }}
                    />
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div className="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div className="p-6 border-b border-slate-200">
          <h2 className="text-lg">Recent Tickets</h2>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-slate-50 border-b border-slate-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">ID</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Status</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Client</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Description</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Collaborator</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Opened</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-200">
              {recentTickets.map(ticket => {
                const client = clients.find(c => c.id === ticket.clientId);
                const collaborator = collaborators.find(c => c.id === ticket.primaryCollaboratorId);
                return (
                  <tr
                    key={ticket.id}
                    onClick={() => navigate(`/tickets/${ticket.id}`)}
                    className="hover:bg-slate-50 cursor-pointer"
                  >
                    <td className="px-6 py-4 text-sm">#{ticket.id}</td>
                    <td className="px-6 py-4">
                      <StatusBadge status={ticket.status} />
                    </td>
                    <td className="px-6 py-4 text-sm">{client?.name}</td>
                    <td className="px-6 py-4 text-sm max-w-md truncate">{ticket.description}</td>
                    <td className="px-6 py-4 text-sm">{collaborator?.name}</td>
                    <td className="px-6 py-4 text-sm text-slate-600">{formatRelativeTime(ticket.createdAt)}</td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
