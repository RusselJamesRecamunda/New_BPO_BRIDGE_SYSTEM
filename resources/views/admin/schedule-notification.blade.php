<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <title>Confirm Schedule</title>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4s1B6jppxmnKmXUcvVRxTg0gRwg9GHmZ4ukY0ZfsyTLn7pHLUBoBiDnycYLTzZAd" crossorigin="anonymous">
  
  </head>
  <body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead">
                <a href="https://example.com" class="f-fallback email-masthead_name">
                <center><img src="cid:bpo_logo" alt="BPO Logo" style="width: 200px; height: 200px; margin: -40px 0 -40px;"></center>
                </a>                                
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="570" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                    <center><img src="cid:congrats" alt="Celebration Image" style="width: 300px; height: 300px; margin: 5px 0 5px;"></center>
                      <div class="f-fallback">
                        <h1>Dear candidate!</h1>
                        <p>We are pleased to inform you that your application for the {{ $applied_job }} has been successfully reviewed,
                            and we would like to invite you for a job interview.
                        </p>
                        <p>This interview will provide us with an opportunity to further discuss your skills, suitability for the role, and to learn more about your career aspirations.
                            <br>
                            Date: <strong>{{ $interview_date }}</strong>
                            <br>
                            Time: <strong>{{ $interview_time }}</strong>
                            <br>
                            Mode of Interview: <strong>{{ $interview_mode }} </strong> <br> {{ $zoom_link }}
                            <br>
                        </p>
                        <p>Please confirm your availability <strong>by filling out the form below</strong>, within 48 hours of receiving this email. </p>
                        <p>
                            Best regards,
                            <br>
                            Applicant Name: <strong>{{ $candidate_name }} </strong>
                            <br>
                            Applied Job: <strong>{{ $applied_job }} </strong>
                            <br>
                            BPO-BRIDGE
                            <br>
                            Contact Information:<br>
                            bpobridge2024@gmail.com
                        </p>

                         <!-- Availability Form -->
                         <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f5f5f5; height: 80vh; text-align: center;">
                          <tr>
                            <td align="center" valign="middle">
                              <table width="400" cellspacing="0" cellpadding="20" style="background-color: #fff; border-radius: 10px; text-align: left;">
                                <tr>
                                  <td>
                                    <h2 style="font-size: 24px; color: #333; text-align: center; margin-bottom: 20px;">Confirm Your Availability</h2>
                                    <form style="width: 100%; margin: auto;">
                                      <div style="margin-bottom: 15px;">
                                        <label for="name" style="display: block; font-size: 14px; color: #333; margin-bottom: 5px;"><strong>Enter Your Name:</strong></label>
                                        <input type="text" id="name" name="name" placeholder="Enter Your Name" 
                                              style="width: 94%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;" required>
                                      </div>
                                      <div style="margin-bottom: 15px;">
                                        <label for="email" style="display: block; font-size: 14px; color: #333; margin-bottom: 5px;"><strong>Enter Your Email:</strong></label>
                                        <input type="email" id="email" name="email" placeholder="Enter Your Email" 
                                              style="width: 94%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;" required>
                                      </div>
                                      <div style="margin-bottom: 15px;">
                                        <label for="availability" style="display: block; font-size: 14px; color: #333; margin-bottom: 5px;"><strong>Availability:</strong></label>
                                        <select id="availability" name="availability" 
                                                style="width: 100%; padding: 10px; font-size: 14px; border-radius: 5px; border: 1px solid #ccc;" required>
                                          <option value="" disabled selected>Select Option</option>
                                          <option value="available">Yes, I am available</option>
                                          <option value="not_available">No, I am not available</option>
                                          <option value="alternate">Prefer an alternate slot</option>
                                        </select>
                                      </div>
                                      <div style="text-align: center; margin-top: 20px;">
                                        <button type="submit" 
                                                style="padding: 12px 20px; font-size: 16px; color: #fff; background-color: #0F5078; border: none; border-radius: 5px; cursor: pointer; width: 100%;">
                                          Submit
                                        </button>
                                      </div>
                                    </form>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>

                        <!-- Sub copy -->
                        <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                              <p class="f-fallback sub"></p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
              <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                  <td class="content-cell" align="center">
                    <p class="f-fallback sub align-center">
                      BPO-BRIDGE © 2024. All rights reserved
                      <br>Legazpi City, Albay
                    </p>
                  </td>
                </tr>
              </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRLx5HGzBPX5I5EyZ0Im3IIkPiKmnAfh0dP3P3ISD" crossorigin="anonymous"></script>
  </body>
</html>
