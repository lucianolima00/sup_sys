import { useState } from 'react';
import { useApp } from '../context/AppContext';
import { Plus, Search } from 'lucide-react';
import { formatCPFCNPJ } from '../utils/format';
import { Collaborator, CollaboratorType } from '../data/types';
import { toast } from 'sonner';

export default function CollaboratorsList() {
  const { collaborators, tickets, addCollaborator, updateCollaborator, deleteCollaborator } = useApp();
  const [searchTerm, setSearchTerm] = useState('');
  const [typeFilter, setTypeFilter] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [editingCollaborator, setEditingCollaborator] = useState<Collaborator | null>(null);
  const [formData, setFormData] = useState({
    name: '',
    cpfCnpj: '',
    email: '',
    type: 'technician' as CollaboratorType,
  });

  const filteredCollaborators = collaborators.filter(collab => {
    const matchesSearch =
      searchTerm === '' ||
      collab.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      collab.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
      collab.cpfCnpj.includes(searchTerm);

    const matchesType = typeFilter === '' || collab.type === typeFilter;

    return matchesSearch && matchesType;
  });

  const getActiveTicketCount = (collabId: string) => {
    return tickets.filter(
      t =>
        (t.primaryCollaboratorId === collabId || t.secondaryCollaboratorId === collabId) &&
        t.status !== 'closed' &&
        t.status !== 'cancelled'
    ).length;
  };

  const handleAdd = () => {
    setEditingCollaborator(null);
    setFormData({
      name: '',
      cpfCnpj: '',
      email: '',
      type: 'technician',
    });
    setShowModal(true);
  };

  const handleEdit = (collab: Collaborator) => {
    setEditingCollaborator(collab);
    setFormData({
      name: collab.name,
      cpfCnpj: collab.cpfCnpj,
      email: collab.email,
      type: collab.type,
    });
    setShowModal(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (editingCollaborator) {
      updateCollaborator(editingCollaborator.id, formData);
      toast.success('Collaborator updated successfully!');
    } else {
      const newCollaborator: Collaborator = {
        id: String(collaborators.length + 1),
        ...formData,
      };
      addCollaborator(newCollaborator);
      toast.success('Collaborator created successfully!');
    }

    setShowModal(false);
  };

  const handleDelete = (id: string) => {
    if (confirm('Are you sure you want to delete this collaborator?')) {
      deleteCollaborator(id);
      toast.success('Collaborator deleted successfully!');
    }
  };

  const typeConfig = {
    technician: { label: 'Technician', color: 'bg-blue-100 text-blue-700' },
    analyst: { label: 'Analyst', color: 'bg-purple-100 text-purple-700' },
    manager: { label: 'Manager', color: 'bg-teal-100 text-teal-700' },
  };

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center justify-between">
        <h1 className="text-3xl">Collaborators</h1>
        <button
          onClick={handleAdd}
          className="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
        >
          <Plus className="w-5 h-5" />
          New Collaborator
        </button>
      </div>

      <div className="bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
        <div className="flex gap-4">
          <div className="flex-1 relative">
            <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
            <input
              type="text"
              placeholder="Search by name, email, or CPF/CNPJ..."
              value={searchTerm}
              onChange={e => setSearchTerm(e.target.value)}
              className="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
          </div>
          <select
            value={typeFilter}
            onChange={e => setTypeFilter(e.target.value)}
            className="px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
          >
            <option value="">All Types</option>
            <option value="technician">Technician</option>
            <option value="analyst">Analyst</option>
            <option value="manager">Manager</option>
          </select>
        </div>
      </div>

      <div className="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-slate-50 border-b border-slate-200">
              <tr>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Name</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Type</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">CPF/CNPJ</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Email</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Active Tickets</th>
                <th className="px-6 py-3 text-left text-xs uppercase text-slate-600">Actions</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-200">
              {filteredCollaborators.length === 0 ? (
                <tr>
                  <td colSpan={6} className="px-6 py-12 text-center text-slate-500">
                    No collaborators found.
                  </td>
                </tr>
              ) : (
                filteredCollaborators.map(collab => (
                  <tr key={collab.id} className="hover:bg-slate-50">
                    <td className="px-6 py-4 text-sm">{collab.name}</td>
                    <td className="px-6 py-4">
                      <span className={`inline-flex items-center px-2.5 py-0.5 rounded-md text-xs ${typeConfig[collab.type].color}`}>
                        {typeConfig[collab.type].label}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-sm">{formatCPFCNPJ(collab.cpfCnpj)}</td>
                    <td className="px-6 py-4 text-sm">{collab.email}</td>
                    <td className="px-6 py-4">
                      <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">
                        {getActiveTicketCount(collab.id)}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex gap-2">
                        <button
                          onClick={() => handleEdit(collab)}
                          className="text-sm text-indigo-600 hover:text-indigo-700"
                        >
                          Edit
                        </button>
                        <button
                          onClick={() => handleDelete(collab.id)}
                          className="text-sm text-red-600 hover:text-red-700"
                        >
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                ))
              )}
            </tbody>
          </table>
        </div>
      </div>

      {showModal && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
          <div className="bg-white rounded-lg max-w-md w-full p-6 space-y-4">
            <h2 className="text-xl">{editingCollaborator ? 'Edit Collaborator' : 'New Collaborator'}</h2>

            <form onSubmit={handleSubmit} className="space-y-4">
              <div>
                <label className="block text-sm mb-2">
                  Name <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={formData.name}
                  onChange={e => setFormData({ ...formData, name: e.target.value })}
                  className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label className="block text-sm mb-2">
                  CPF/CNPJ <span className="text-red-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={formData.cpfCnpj}
                  onChange={e => setFormData({ ...formData, cpfCnpj: e.target.value })}
                  className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  placeholder="000.000.000-00"
                />
              </div>

              <div>
                <label className="block text-sm mb-2">
                  Email <span className="text-red-500">*</span>
                </label>
                <input
                  type="email"
                  required
                  value={formData.email}
                  onChange={e => setFormData({ ...formData, email: e.target.value })}
                  className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
              </div>

              <div>
                <label className="block text-sm mb-2">
                  Type <span className="text-red-500">*</span>
                </label>
                <select
                  value={formData.type}
                  onChange={e => setFormData({ ...formData, type: e.target.value as CollaboratorType })}
                  className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                  <option value="technician">Technician</option>
                  <option value="analyst">Analyst</option>
                  <option value="manager">Manager</option>
                </select>
              </div>

              <div className="flex gap-3 pt-4">
                <button
                  type="submit"
                  className="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
                >
                  {editingCollaborator ? 'Update' : 'Create'}
                </button>
                <button
                  type="button"
                  onClick={() => setShowModal(false)}
                  className="flex-1 px-4 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
                >
                  Cancel
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
}
