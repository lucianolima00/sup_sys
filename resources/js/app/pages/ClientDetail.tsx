import { useParams, useNavigate } from 'react-router-dom';
import { useApp } from '../context/AppContext';
import { ArrowLeft, Edit, MapPin, Mail, Phone, Building, FileText } from 'lucide-react';
import { formatCPFCNPJ, formatAddress, formatDate } from '../utils/format';
import StatusBadge from '../components/StatusBadge';
import { useState } from 'react';
import { toast } from 'sonner';
import { Client } from '../data/types';

export default function ClientDetail() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const { clients, tickets, updateClient, deleteClient } = useApp();
  const [isEditing, setIsEditing] = useState(false);
  const [formData, setFormData] = useState<Client | null>(null);

  const client = clients.find(c => c.id === id);
  const clientTickets = tickets.filter(t => t.clientId === id);

  if (!client) {
    return (
      <div className="p-8">
        <div className="text-center py-12">
          <p className="text-slate-600">Client not found</p>
          <button
            onClick={() => navigate('/clients')}
            className="mt-4 text-indigo-600 hover:text-indigo-700"
          >
            Back to clients
          </button>
        </div>
      </div>
    );
  }

  const handleEdit = () => {
    setFormData(client);
    setIsEditing(true);
  };

  const handleSave = () => {
    if (formData) {
      updateClient(client.id, formData);
      setIsEditing(false);
      toast.success('Client updated successfully!');
    }
  };

  const handleDelete = () => {
    if (confirm('Are you sure you want to delete this client?')) {
      deleteClient(client.id);
      toast.success('Client deleted successfully!');
      navigate('/clients');
    }
  };

  const displayData = isEditing && formData ? formData : client;

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center gap-4">
        <button
          onClick={() => navigate('/clients')}
          className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
        >
          <ArrowLeft className="w-5 h-5" />
        </button>
        <h1 className="text-3xl flex-1">{client.name}</h1>
        {!isEditing ? (
          <button
            onClick={handleEdit}
            className="flex items-center gap-2 px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
          >
            <Edit className="w-4 h-4" />
            Edit
          </button>
        ) : (
          <div className="flex gap-2">
            <button
              onClick={handleSave}
              className="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
            >
              Save
            </button>
            <button
              onClick={() => setIsEditing(false)}
              className="px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
            >
              Cancel
            </button>
          </div>
        )}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2 space-y-6">
          <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h2 className="text-lg mb-4 flex items-center gap-2">
              <Building className="w-5 h-5" />
              Company Information
            </h2>
            {isEditing && formData ? (
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm mb-2">Name</label>
                  <input
                    type="text"
                    value={formData.name}
                    onChange={e => setFormData({ ...formData, name: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Company Name</label>
                  <input
                    type="text"
                    value={formData.companyName}
                    onChange={e => setFormData({ ...formData, companyName: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">CPF/CNPJ</label>
                  <input
                    type="text"
                    value={formData.cpfCnpj}
                    onChange={e => setFormData({ ...formData, cpfCnpj: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
              </div>
            ) : (
              <div className="space-y-3">
                <div>
                  <p className="text-sm text-slate-600">Company Name</p>
                  <p className="text-lg">{displayData.companyName}</p>
                </div>
                <div>
                  <p className="text-sm text-slate-600">CPF/CNPJ</p>
                  <p>{formatCPFCNPJ(displayData.cpfCnpj)}</p>
                </div>
              </div>
            )}
          </div>

          <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h2 className="text-lg mb-4 flex items-center gap-2">
              <Mail className="w-5 h-5" />
              Contact Information
            </h2>
            {isEditing && formData ? (
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm mb-2">Email</label>
                  <input
                    type="email"
                    value={formData.email}
                    onChange={e => setFormData({ ...formData, email: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Phone</label>
                  <input
                    type="text"
                    value={formData.phone}
                    onChange={e => setFormData({ ...formData, phone: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
              </div>
            ) : (
              <div className="space-y-3">
                <div className="flex items-center gap-2">
                  <Mail className="w-4 h-4 text-slate-400" />
                  <a href={`mailto:${displayData.email}`} className="text-indigo-600 hover:text-indigo-700">
                    {displayData.email}
                  </a>
                </div>
                <div className="flex items-center gap-2">
                  <Phone className="w-4 h-4 text-slate-400" />
                  <a href={`tel:${displayData.phone}`} className="text-indigo-600 hover:text-indigo-700">
                    {displayData.phone}
                  </a>
                </div>
              </div>
            )}
          </div>

          <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h2 className="text-lg mb-4 flex items-center gap-2">
              <MapPin className="w-5 h-5" />
              Address
            </h2>
            {isEditing && formData ? (
              <div className="grid grid-cols-2 gap-4">
                <div className="col-span-2">
                  <label className="block text-sm mb-2">Logradouro</label>
                  <input
                    type="text"
                    value={formData.logradouro}
                    onChange={e => setFormData({ ...formData, logradouro: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Número</label>
                  <input
                    type="text"
                    value={formData.numero}
                    onChange={e => setFormData({ ...formData, numero: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Complemento</label>
                  <input
                    type="text"
                    value={formData.complemento}
                    onChange={e => setFormData({ ...formData, complemento: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">CEP</label>
                  <input
                    type="text"
                    value={formData.cep}
                    onChange={e => setFormData({ ...formData, cep: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Bairro</label>
                  <input
                    type="text"
                    value={formData.bairro}
                    onChange={e => setFormData({ ...formData, bairro: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Cidade</label>
                  <input
                    type="text"
                    value={formData.cidade}
                    onChange={e => setFormData({ ...formData, cidade: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Estado</label>
                  <input
                    type="text"
                    value={formData.estado}
                    onChange={e => setFormData({ ...formData, estado: e.target.value })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    maxLength={2}
                  />
                </div>
              </div>
            ) : (
              <p className="text-slate-700">{formatAddress(displayData)}</p>
            )}
          </div>
        </div>

        <div className="space-y-6">
          <div className="bg-white p-6 rounded-lg border border-slate-200 shadow-sm">
            <h2 className="text-lg mb-4 flex items-center gap-2">
              <FileText className="w-5 h-5" />
              Related Tickets
            </h2>
            <div className="space-y-3">
              {clientTickets.length === 0 ? (
                <p className="text-sm text-slate-500">No tickets found</p>
              ) : (
                clientTickets.slice(0, 5).map(ticket => (
                  <div
                    key={ticket.id}
                    onClick={() => navigate(`/tickets/${ticket.id}`)}
                    className="p-3 bg-slate-50 rounded-lg hover:bg-slate-100 cursor-pointer transition-colors"
                  >
                    <div className="flex items-center justify-between mb-2">
                      <span className="text-sm">#{ticket.id}</span>
                      <StatusBadge status={ticket.status} />
                    </div>
                    <p className="text-sm text-slate-600 truncate">{ticket.description}</p>
                    <p className="text-xs text-slate-500 mt-1">{formatDate(ticket.openingDate)}</p>
                  </div>
                ))
              )}
              {clientTickets.length > 5 && (
                <button
                  onClick={() => navigate('/tickets')}
                  className="text-sm text-indigo-600 hover:text-indigo-700"
                >
                  View all {clientTickets.length} tickets
                </button>
              )}
            </div>
          </div>

          {!isEditing && (
            <button
              onClick={handleDelete}
              className="w-full px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors"
            >
              Delete Client
            </button>
          )}
        </div>
      </div>
    </div>
  );
}
