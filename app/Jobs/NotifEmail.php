<?php

namespace App\Jobs;

use App\Models\Setting;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;

class NotifEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    // protected $emailuser;
    // protected $nameuser;
    protected $addRecipient;
    protected $ccRecipient;
    protected $ccRole;
    protected $subjectEmail;
    protected $bodyEmail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    // public function __construct($emailuser, $nameuser, $headRecipient, $picsRecipient, $subjectEmail, $bodyEmail)
    public function __construct($addRecipient, $ccRecipient, $ccRole, $subjectEmail, $bodyEmail)
    {

        $this->addRecipient = $addRecipient;
        $this->ccRecipient = $ccRecipient;
        $this->ccRole = $ccRole;
        $this->subjectEmail = $subjectEmail;
        $this->bodyEmail = $bodyEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $settings = Setting::select('key','value')->get()->pluck('value','key')->toArray();

        $Host = $settings['smtp_host'] ?? '';
        $SMTPAuth = $settings['smtp_auth'] ?? '';
        $Username = $settings['u_email'] ?? '';
        $Password = $settings['p_email'] ?? '';
        $SMTPAutoTLS = $settings['smtp_auto_tls'] ?? '';
        $SMTPSecure = $settings['smtp_secure'] ?? '';
        $Port = $settings['port'] ?? '';


        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $Host;
        $mail->SMTPAuth = $SMTPAuth;
        $mail->Username   = $Username;                     //SMTP username
        $mail->Password   = $Password;
        $mail->SMTPAutoTLS = $SMTPAutoTLS;
        $mail->SMTPSecure = $SMTPSecure;
        $mail->Port       = $Port;

        $mail->setFrom('compass@compass-tsel.id', 'Compass-Tsel');
        $mail->addReplyTo('compass@compass-tsel.id', 'Compass-Tsel');

        if ($this->addRecipient != null) {
            $arrRec = explode(',',$this->addRecipient);

            foreach ($arrRec as $aR) {
                $toAdds = UserContact::where('user_id', $aR)->get();
                foreach ($toAdds as $toAdd) {
                    # code...
                    $mail->addAddress($toAdd->email, $toAdd->name);
                }
            }
        }

        if ($this->ccRecipient != null) {
            $arrCcRec = explode(',',$this->ccRecipient);
            foreach ($arrCcRec as $aCR) {
                // $toCC = User::find($this->ccRecipient);
                $toCCs = UserContact::where('user_id', $aCR)->get();
                foreach ($toCCs as $toCC) {
                    # code...
                    $mail->addCc($toCC->email, $toCC->name);
                }
            }
        }

        if ($this->ccRole != null) {
            $ccRole = explode(',',$this->ccRole);
            foreach ($ccRole as $ccR) {
                $toCCs = User::where('type', $ccR)->get();
                foreach ($toCCs as $cc) {
                    # code...
                    $roleEs = UserContact::where('user_id', $cc->id)->get();
                    foreach ($roleEs as $rEmail) {
                        # code...
                        $mail->addAddress($rEmail->email, $rEmail->name);
                    }
                    // $mail->addCc($cc->email, $cc->name);
                }
            }
        }

        $mail->isHTML(true);
        $mail->Subject = $this->subjectEmail;

        $mail->Body = $this->bodyEmail;

        $mail->AltBody = $this->bodyEmail;

        if (!$mail->send()) {
            echo 'Mailer Error: '. $mail->ErrorInfo;

            // \Log::channel('email')->info('Mailer Error: ', $mail->ErrorInfo);
        } else {
            // echo 'Message sent!';
        }
    }
}
