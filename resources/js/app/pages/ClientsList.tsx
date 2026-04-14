import { useState } from 'react';
import { useApp } from '../context/AppContext';
import { useNavigate } from 'react-router-dom';
import { Plus, Search } from 'lucide-react';
import { formatCPFCNPJ } from '../utils/format';

export default function ClientsList() {
  const { clients, tickets } = useApp();
  const navigate = useNavigate();
  const [searchTerm, setSearchTerm] = useState('');

  const filteredClients = clients.filter(client => {
    const searchLower = searchTerm.toLowerCase();
    return (
      client.name.toLowerCase().includes(searchLower) ||
      client.companyName.toLowerCase().includes(searchLower) ||
      client.cpfCnpj.includes(searchTerm) ||
      client.email.toLowerCase().includes(searchLower) ||
      client.cidade.toLowerCase().includes(searchLower) ||
      client.estado.toLowerCase().includes(searchLower)
    );
  });

  const getClientTicketCount = (clientId: string) => {
    return tickets.filter(t => t.clientId === clientId).length;
  };

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-3xl">Clients</h1>
        <button
          onClick={() => navigate('/clients/new')}
          className="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
        >
          <Plus className="w-5 h-5" />
          New Client
        </button>
      </div>

      <div className="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
        <div className="relative">
          <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
          <input
            type="text"
            placeholder="Search by name, company, CPF/CNPJ, email, or city..."
            value={searchTerm}
            onChange={e => setSearchTerm(e.target.value)}
            className="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          />
        </div>
      </div>

      <div className="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-slate-50 border-b border-slate-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Name</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Company</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">CPF/CNPJ</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Email</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Phone</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">City/State</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Tickets</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-200">
              {filteredClients.length === 0 ? (
                <tr>
                  <td colSpan={7} className="px-6 py-12 text-center text-slate-500">
                    No clients found. Try adjusting your search.
                  </td>
                </tr>
              ) : (
                filteredClients.map(client => (
                  <tr
                    key={client.id}
                    onClick={() => navigate(`/clients/${client.id}`)}
                    className="hover:bg-slate-50 cursor-pointer"
                  >
                    <td className="px-6 py-4 text-sm">{client.name}</td>
                    <td className="px-6 py-4 text-sm">{client.companyName}</td>
                    <td className="px-6 py-4 text-sm">{formatCPFCNPJ(client.cpfCnpj)}</td>
                    <td className="px-6 py-4 text-sm">{client.email}</td>
                    <td className="px-6 py-4 text-sm">{client.phone}</td>
                    <td className="px-6 py-4 text-sm">{client.cidade}/{client.estado}</td>
                    <td className="px-6 py-4">
                      <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">
                        {getClientTicketCount(client.id)}
                      </span>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      </div>

      <div className="text-sm text-slate-600">
        Showing {filteredClients.length} of {clients.length} clients
      </div>
    </div>
  );
}
