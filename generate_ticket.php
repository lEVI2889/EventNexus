<?php
require_once 'dompdf/autoload.inc.php';
require_once 'DBconnect.php';
session_start();

use Dompdf\Dompdf;

if (isset($_GET['ticket_id'])) {
    $ticket_id = mysqli_real_escape_string($conn, $_GET['ticket_id']);
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT b.ticket_id, e.title, e.event_date, e.start_time, t.price, u.full_name 
              FROM Books b 
              JOIN EventShow e ON b.event_id = e.event_id 
              JOIN Ticket t ON b.ticket_id = t.ticket_id
              JOIN Users u ON b.user_id = u.user_id
              WHERE b.ticket_id = '$ticket_id' AND b.user_id = '$user_id'";

    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $dompdf = new Dompdf();
        
        $html = "
        <style>
            body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; }
            .ticket-container {
                width: 100%;
                border: 2px solid #2c3e50;
                border-radius: 12px;
                overflow: hidden;
            }
            .header-strip {
                background-color: #2c3e50;
                color: white;
                padding: 15px;
                text-align: center;
            }
            .header-strip h1 { margin: 0; font-size: 22px; letter-spacing: 3px; text-transform: uppercase; }
            .content { padding: 25px; position: relative; }
            
            /* Main details on the left */
            .main-details { width: 65%; float: left; border-right: 2px dashed #bdc3c7; padding-right: 15px; }
            
            /* Stub details on the right */
            .stub-details { width: 25%; float: right; text-align: right; }
            
            .label { font-size: 10px; color: #7f8c8d; text-transform: uppercase; font-weight: bold; margin-bottom: 3px; }
            .value { font-size: 15px; font-weight: bold; margin-bottom: 18px; color: #2c3e50; }
            .event-title { font-size: 24px; color: #2c3e50; margin-bottom: 25px; font-weight: bold; }
            
            /* Pricing and Ticket ID Section */
            .price-tag { font-size: 26px; color: #27ae60; font-weight: bold; margin-top: 10px; }
            .ticket-no { font-size: 22px; color: #34495e; font-weight: bold; }
            
            .footer {
                clear: both;
                background: #fdfdfd;
                padding: 12px;
                text-align: center;
                font-size: 10px;
                color: #95a5a6;
                border-top: 1px solid #ecf0f1;
            }
            .clearfix::after { content: ''; clear: both; display: table; }
        </style>
        
        <div class='ticket-container'>
            <div class='header-strip'>
                <h1>EventNexus Admit One</h1>
            </div>
            
            <div class='content clearfix'>
                <div class='main-details'>
                    <div class='label'>Event Name</div>
                    <div class='event-title'>".htmlspecialchars($data['title'])."</div>
                    
                    <div style='margin-bottom: 20px;'>
                        <div class='label'>Attendee Name</div>
                        <div class='value'>".htmlspecialchars($data['full_name'])."</div>
                    </div>
                    
                    <div>
                        <div class='label'>Event Date & Start Time</div>
                        <div class='value'>".date('F j, Y', strtotime($data['event_date']))." at ".date('h:i A', strtotime($data['start_time']))."</div>
                    </div>
                </div>
                
                <div class='stub-details'>
                    <div style='margin-bottom: 30px;'>
                        <div class='label'>Ticket No.</div>
                        <div class='ticket-no'>#".$data['ticket_id']."</div>
                    </div>
                    
                    <div>
                        <div class='label'>Entry Price</div>
                        <div class='price-tag'>TAKA ".number_format($data['price'], 2)."</div>
                    </div>
                </div>
            </div>
            
            <div class='footer'>
                Non-Transferable. Scan QR/Barcode at entry. Powered by EventNexus Management.
            </div>
        </div>";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'landscape'); 
        $dompdf->render();
        
        ob_end_clean(); 
        $dompdf->stream("EventNexus_Ticket_".$data['ticket_id'].".pdf", array("Attachment" => 1));
    }
}
?>