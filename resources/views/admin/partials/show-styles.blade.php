/*
* Admin Show Page Common Styles
* Konsisten styling untuk semua halaman detail admin
*/

.admin-show-container {
max-width: 1200px;
margin: 0 auto;
padding: 20px;
font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Page Header */
.admin-show-header {
display: flex;
justify-content: space-between;
align-items: center;
margin-bottom: 30px;
padding-bottom: 20px;
border-bottom: 2px solid #e3e6f0;
}

.admin-show-title {
font-size: 2rem;
font-weight: 600;
color: #333;
margin: 0;
}

.admin-show-breadcrumb {
list-style: none;
padding: 0;
margin: 8px 0 0 0;
display: flex;
gap: 8px;
font-size: 14px;
}

.admin-show-breadcrumb li:not(:last-child)::after {
content: '>';
margin-left: 8px;
color: #666;
}

.admin-show-breadcrumb a {
color: #007bff;
text-decoration: none;
}

.admin-show-breadcrumb a:hover {
text-decoration: underline;
}

/* Button Groups */
.admin-show-btn-group {
display: flex;
gap: 10px;
flex-wrap: wrap;
}

.admin-show-btn {
display: inline-flex;
align-items: center;
padding: 10px 16px;
font-size: 14px;
font-weight: 500;
border: none;
border-radius: 8px;
cursor: pointer;
text-decoration: none;
transition: all 0.3s ease;
min-width: 100px;
justify-content: center;
}

.admin-show-btn:hover {
transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.admin-show-btn-primary {
background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
color: white;
}

.admin-show-btn-warning {
background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
color: #212529;
}

.admin-show-btn-secondary {
background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
color: white;
}

.admin-show-btn-danger {
background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
color: white;
}

.admin-show-btn-success {
background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
color: white;
}

/* Cards */
.admin-show-card {
background: white;
border-radius: 12px;
box-shadow: 0 4px 20px rgba(0,0,0,0.1);
overflow: hidden;
margin-bottom: 30px;
}

.admin-show-card-header {
background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
color: white;
padding: 20px;
display: flex;
justify-content: space-between;
align-items: center;
}

.admin-show-card-header h6 {
margin: 0;
font-size: 18px;
font-weight: 600;
}

.admin-show-card-body {
padding: 30px;
}

/* Main Layout */
.admin-show-layout {
display: grid;
grid-template-columns: 2fr 1fr;
gap: 30px;
}

/* Content Section */
.admin-show-content h1,
.admin-show-content h2,
.admin-show-content h3,
.admin-show-content h4,
.admin-show-content h5 {
color: #333;
margin-bottom: 15px;
}

.admin-show-content p {
color: #666;
line-height: 1.6;
margin-bottom: 16px;
}

.admin-show-image {
max-width: 100%;
height: auto;
border-radius: 12px;
box-shadow: 0 8px 24px rgba(0,0,0,0.15);
cursor: pointer;
transition: transform 0.3s ease;
margin-bottom: 20px;
}

.admin-show-image:hover {
transform: scale(1.02);
}

/* Info Panel */
.admin-show-info-panel {
background: #f8f9fc;
border: 1px solid #e3e6f0;
border-radius: 12px;
overflow: hidden;
}

.admin-show-info-header {
background: #f1f3f4;
padding: 15px 20px;
border-bottom: 1px solid #e3e6f0;
}

.admin-show-info-header h6 {
margin: 0;
font-size: 16px;
font-weight: 600;
color: #333;
}

.admin-show-info-table {
width: 100%;
border-collapse: collapse;
}

.admin-show-info-table tr {
border-bottom: 1px solid #e3e6f0;
}

.admin-show-info-table tr:last-child {
border-bottom: none;
}

.admin-show-info-table th,
.admin-show-info-table td {
padding: 12px 20px;
text-align: left;
vertical-align: top;
}

.admin-show-info-table th {
font-weight: 600;
color: #333;
width: 40%;
}

.admin-show-info-table td {
color: #666;
}

/* Badges */
.admin-show-badge {
display: inline-block;
padding: 4px 12px;
font-size: 12px;
font-weight: 500;
border-radius: 20px;
text-transform: uppercase;
letter-spacing: 0.5px;
}

.admin-show-badge-primary {
background: #007bff;
color: white;
}

.admin-show-badge-success {
background: #28a745;
color: white;
}

.admin-show-badge-warning {
background: #ffc107;
color: #212529;
}

.admin-show-badge-danger {
background: #dc3545;
color: white;
}

.admin-show-badge-secondary {
background: #6c757d;
color: white;
}

/* Action Buttons Area */
.admin-show-actions {
padding: 20px;
border-top: 1px solid #e3e6f0;
background: #f8f9fc;
}

.admin-show-actions .admin-show-btn {
width: 100%;
margin-bottom: 10px;
}

/* Modals */
.admin-show-modal {
display: none;
position: fixed;
z-index: 1000;
left: 0;
top: 0;
width: 100%;
height: 100%;
background-color: rgba(0,0,0,0.8);
}

.admin-show-modal.show {
display: flex;
align-items: center;
justify-content: center;
}

.admin-show-modal-content {
background: white;
border-radius: 12px;
padding: 30px;
max-width: 500px;
width: 90%;
text-align: center;
}

.admin-show-modal-image {
max-width: 90vw;
max-height: 90vh;
border-radius: 8px;
}

.admin-show-modal-close {
position: absolute;
top: 15px;
right: 25px;
color: white;
font-size: 35px;
font-weight: bold;
cursor: pointer;
transition: opacity 0.3s ease;
}

.admin-show-modal-close:hover {
opacity: 0.7;
}

/* Status Indicators */
.admin-show-status-aktif {
color: #28a745;
font-weight: 600;
}

.admin-show-status-nonaktif {
color: #dc3545;
font-weight: 600;
}

.admin-show-status-pending {
color: #ffc107;
font-weight: 600;
}

/* Video Container */
.admin-show-video {
position: relative;
width: 100%;
padding-bottom: 56.25%; /* 16:9 aspect ratio */
height: 0;
border-radius: 12px;
overflow: hidden;
box-shadow: 0 8px 24px rgba(0,0,0,0.15);
margin-bottom: 20px;
}

.admin-show-video iframe {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
}

/* Timeline (for history) */
.admin-show-timeline {
position: relative;
padding-left: 30px;
}

.admin-show-timeline-item {
position: relative;
margin-bottom: 25px;
padding-left: 25px;
}

.admin-show-timeline-item:not(:last-child)::before {
content: '';
position: absolute;
left: -22px;
top: 30px;
width: 2px;
height: calc(100% + 10px);
background-color: #e3e6f0;
}

.admin-show-timeline-icon {
position: absolute;
left: -30px;
top: 5px;
width: 16px;
height: 16px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
font-size: 10px;
color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
.admin-show-layout {
grid-template-columns: 1fr;
}

.admin-show-header {
flex-direction: column;
align-items: flex-start;
gap: 15px;
}

.admin-show-btn-group {
width: 100%;
flex-direction: column;
}

.admin-show-card-header {
flex-direction: column;
align-items: flex-start;
gap: 15px;
}

.admin-show-container {
padding: 15px;
}
}

/* Utility Classes */
.admin-show-text-center {
text-align: center;
}

.admin-show-text-muted {
color: #6c757d;
}

.admin-show-mb-0 {
margin-bottom: 0;
}

.admin-show-mb-2 {
margin-bottom: 0.5rem;
}

.admin-show-mb-3 {
margin-bottom: 1rem;
}

.admin-show-mt-3 {
margin-top: 1rem;
}

.admin-show-d-flex {
display: flex;
}

.admin-show-align-center {
align-items: center;
}

.admin-show-justify-between {
justify-content: space-between;
}

.admin-show-gap-2 {
gap: 0.5rem;
}
