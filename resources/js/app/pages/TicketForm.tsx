import { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { useApp } from '../context/AppContext';
import { ArrowLeft, Save } from 'lucide-react';
import { Ticket, TicketStatus } from '../data/types';
import { toast } from 'sonner';

export default function TicketForm() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const { tickets, clients, collaborators, currentUser, addTicket, updateTicket } = useApp();

  const isEditMode = !!id;
  const existingTicket = isEditMode ? tickets.find(t => t.id === id) : null;

  const [formData, setFormData] = useState({
    clientId: existingTicket?.clientId || '',
    primaryCollaboratorId: existingTicket?.primaryCollaboratorId || '',
    secondaryCollaboratorId: existingTicket?.secondaryCollaboratorId || '',
    openingDate: existingTicket?.openingDate || new Date().toISOString().split('T')[0],
    scheduledStart: existingTicket?.scheduledStart || '',
    description: existingTicket?.description || '',
    solution: existingTicket?.solution || '',
    status: existingTicket?.status || 'open' as TicketStatus,
    useCustomAddress: false,
    customAddress: {
      logradouro: existingTicket?.addressOverride?.logradouro || '',
      numero: existingTicket?.addressOverride?.numero || '',
      complemento: existingTicket?.addressOverride?.complemento || '',
      cep: existingTicket?.addressOverride?.cep || '',
      bairro: existingTicket?.addressOverride?.bairro || '',
      cidade: existingTicket?.addressOverride?.cidade || '',
      estado: existingTicket?.addressOverride?.estado || '',
    },
  });

  const selectedClient = clients.find(c => c.id === formData.clientId);

  useEffect(() => {
    if (existingTicket?.addressOverride) {
      setFormData(prev => ({ ...prev, useCustomAddress: true }));
    }
  }, [existingTicket]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (!formData.clientId || !formData.primaryCollaboratorId || !formData.description || !formData.scheduledStart) {
      toast.error('Please fill in all required fields');
      return;
    }

    const ticketData: Ticket = {
      id: isEditMode ? existingTicket!.id : String(tickets.length + 1),
      status: formData.status,
      clientId: formData.clientId,
      description: formData.description,
      solution: formData.solution,
      primaryCollaboratorId: formData.primaryCollaboratorId,
      secondaryCollaboratorId: formData.secondaryCollaboratorId || undefined,
      requesterId: currentUser!.id,
      openingDate: formData.openingDate,
      scheduledStart: formData.scheduledStart,
      createdAt: existingTicket?.createdAt || new Date().toISOString(),
      addressOverride: formData.useCustomAddress ? formData.customAddress : undefined,
    };

    if (isEditMode) {
      updateTicket(ticketData.id, ticketData);
      toast.success('Ticket updated successfully!');
    } else {
      addTicket(ticketData);
      toast.success('Ticket created successfully!');
    }

    navigate(`/tickets/${ticketData.id}`);
  };

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center gap-4">
        <button
          onClick={() => navigate(-1)}
          className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
        >
          <ArrowLeft className="w-5 h-5" />
        </button>
        <h1 className="text-3xl">{isEditMode ? 'Edit Ticket' : 'New Ticket'}</h1>
      </div>

      <form onSubmit={handleSubmit} className="bg-white p-8 rounded-lg border border-slate-200 shadow-sm space-y-8">
        <div>
          <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Client Information</h2>
          <div className="space-y-4">
            <div>
              <label className="block text-sm mb-2">
                Client <span className="text-red-500">*</span>
              </label>
              <select
                required
                value={formData.clientId}
                onChange={e => setFormData({ ...formData, clientId: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                <option value="">Select a client</option>
                {clients.map(client => (
                  <option key={client.id} value={client.id}>
                    {client.name} - {client.companyName}
                  </option>
                ))}
              </select>
              <button
                type="button"
                onClick={() => navigate('/clients/new')}
                className="mt-2 text-sm text-indigo-600 hover:text-indigo-700"
              >
                + Register new client
              </button>
            </div>

            {selectedClient && (
              <div className="bg-slate-50 p-4 rounded-lg text-sm">
                <p><strong>Address:</strong> {selectedClient.logradouro}, {selectedClient.numero}</p>
                <p>{selectedClient.bairro}, {selectedClient.cidade} - {selectedClient.estado}</p>
              </div>
            )}

            <div className="flex items-center gap-2">
              <input
                type="checkbox"
                id="customAddress"
                checked={formData.useCustomAddress}
                onChange={e => setFormData({ ...formData, useCustomAddress: e.target.checked })}
                className="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500"
              />
              <label htmlFor="customAddress" className="text-sm">Use different address for this visit</label>
            </div>

            {formData.useCustomAddress && (
              <div className="grid grid-cols-2 gap-4 p-4 bg-blue-50 rounded-lg">
                <div>
                  <label className="block text-sm mb-2">Logradouro</label>
                  <input
                    type="text"
                    value={formData.customAddress.logradouro}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, logradouro: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Número</label>
                  <input
                    type="text"
                    value={formData.customAddress.numero}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, numero: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Complemento</label>
                  <input
                    type="text"
                    value={formData.customAddress.complemento}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, complemento: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">CEP</label>
                  <input
                    type="text"
                    value={formData.customAddress.cep}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, cep: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="00000-000"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Bairro</label>
                  <input
                    type="text"
                    value={formData.customAddress.bairro}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, bairro: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Cidade</label>
                  <input
                    type="text"
                    value={formData.customAddress.cidade}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, cidade: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  />
                </div>
                <div>
                  <label className="block text-sm mb-2">Estado</label>
                  <input
                    type="text"
                    value={formData.customAddress.estado}
                    onChange={e => setFormData({
                      ...formData,
                      customAddress: { ...formData.customAddress, estado: e.target.value }
                    })}
                    className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    placeholder="SP"
                    maxLength={2}
                  />
                </div>
              </div>
            )}
          </div>
        </div>

        <div>
          <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Assignment</h2>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm mb-2">
                Primary Collaborator <span className="text-red-500">*</span>
              </label>
              <select
                required
                value={formData.primaryCollaboratorId}
                onChange={e => setFormData({ ...formData, primaryCollaboratorId: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                <option value="">Select collaborator</option>
                {collaborators.map(collab => (
                  <option key={collab.id} value={collab.id}>
                    {collab.name} ({collab.type})
                  </option>
                ))}
              </select>
            </div>
            <div>
              <label className="block text-sm mb-2">Secondary Collaborator</label>
              <select
                value={formData.secondaryCollaboratorId}
                onChange={e => setFormData({ ...formData, secondaryCollaboratorId: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              >
                <option value="">None</option>
                {collaborators
                  .filter(c => c.id !== formData.primaryCollaboratorId)
                  .map(collab => (
                    <option key={collab.id} value={collab.id}>
                      {collab.name} ({collab.type})
                    </option>
                  ))}
              </select>
            </div>
          </div>
        </div>

        <div>
          <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Details</h2>
          <div className="grid grid-cols-2 gap-4 mb-4">
            <div>
              <label className="block text-sm mb-2">
                Opening Date <span className="text-red-500">*</span>
              </label>
              <input
                type="date"
                required
                value={formData.openingDate}
                onChange={e => setFormData({ ...formData, openingDate: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Scheduled Start <span className="text-red-500">*</span>
              </label>
              <input
                type="datetime-local"
                required
                value={formData.scheduledStart}
                onChange={e => setFormData({ ...formData, scheduledStart: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
          </div>
          <div>
            <label className="block text-sm mb-2">
              Description <span className="text-red-500">*</span>
            </label>
            <textarea
              required
              value={formData.description}
              onChange={e => setFormData({ ...formData, description: e.target.value })}
              rows={6}
              className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Describe the issue or request in detail..."
            />
          </div>
        </div>

        {(isEditMode && (formData.status === 'resolved' || formData.status === 'closed')) && (
          <div>
            <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Solution</h2>
            <textarea
              value={formData.solution}
              onChange={e => setFormData({ ...formData, solution: e.target.value })}
              rows={6}
              className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              placeholder="Describe the solution or actions taken..."
            />
          </div>
        )}

        <div className="flex items-center gap-4 pt-4 border-t border-slate-200">
          <button
            type="submit"
            className="flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            <Save className="w-5 h-5" />
            {isEditMode ? 'Save Changes' : 'Create Ticket'}
          </button>
          <button
            type="button"
            onClick={() => navigate(-1)}
            className="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  );
}
