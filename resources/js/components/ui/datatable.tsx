// components/DashboardDataTable.tsx
import React, { useState } from 'react';
import '../../../css/datatable.css'; // We'll add CSS below

interface User {
  id: number;
  name: string;
  email: string;
  role: string;
  status: 'Active' | 'Inactive' | 'Pending';
  lastLogin: string;
}

const sampleData: User[] = [
  { id: 1, name: 'Emma Thompson', email: 'emma.t@company.com', role: 'Product Designer', status: 'Active', lastLogin: '2 hours ago' },
  { id: 2, name: 'Liam Chen', email: 'liam.c@company.com', role: 'Senior Engineer', status: 'Active', lastLogin: 'Yesterday' },
  { id: 3, name: 'Sophia Rodriguez', email: 'sophia.r@company.com', role: 'Marketing Lead', status: 'Pending', lastLogin: '5 days ago' },
  { id: 4, name: 'Noah Kim', email: 'noah.k@company.com', role: 'Data Analyst', status: 'Active', lastLogin: '1 hour ago' },
  { id: 5, name: 'Olivia Patel', email: 'olivia.p@company.com', role: 'HR Manager', status: 'Inactive', lastLogin: '3 weeks ago' },
];

export default function DashboardDataTable() {
  const [data] = useState<User[]>(sampleData);

  return (
    <div className="table-container">
      <div className="table-header">
        <h2>Team Members</h2>
        <button className="add-btn">+ Add Member</button>
      </div>

      <div className="table-wrapper">
        <table className="dashboard-table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Status</th>
              <th>Last Login</th>
              <th className="actions-col"></th>
            </tr>
          </thead>
          <tbody>
            {data.map((person) => (
              <tr key={person.id}>
                <td className="name-cell">
                  <div className="name-with-avatar">
                    <div className="avatar">{person.name[0]}</div>
                    {person.name}
                  </div>
                </td>
                <td>{person.email}</td>
                <td>{person.role}</td>
                <td>
                <span className={`status-badge ${person.status.toLowerCase()}`}>
                    {person.status}
                </span>
                </td>
                <td className="last-login">{person.lastLogin}</td>
                <td className="actions">
                  <button className="action-btn">Edit</button>
                  <button className="action-btn delete">Delete</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
      <div className="mobile-notice">
        Scroll horizontally → 
      </div>
    </div>
  );
}