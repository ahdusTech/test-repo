<?php

use App\Models\Admin\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailTemplate::create([
            'template_name' => 'Auktion einladen (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Einladung zur Auktion für die Premium Domain [[domain]]',
            'email_text' => '<div class="col-sm-2">
                            <p>[[anrede-nachname]],</p>
                            <p>Sie hatten vor einiger Zeit Interesse daran, die Premium Domain [[domain]] auf der Handelsplattform von Adomino zu erwerben. Der Inhaber der Domain hat sich k&uuml;rzlich dazu entschlossen die Domain &uuml;ber unsere neu entwickelte Auktionsplattform versteigern zu lassen.<br /><br />Die Auktion startet am [[auktion-startzeit]] und endet voraussichtlich am [[auktion-endzeit]], sofern kein Bieter die Domain mittels der Sofortkauf-Option vorzeitig kauft.&nbsp; Falls Sie nach wie vor an der Domain [[domain]] interessiert sind, k&ouml;nnte dies Ihre letzte Chance sein, die Domain zu erwerben!<br /><br />Sie m&ouml;chten sich diese Auktion ansehen oder mitbieten? Dann geben Sie einfach www.[[domain]] in Ihren Browser ein. Die Erkl&auml;rung des Auktionsablaufes finden Sie hier: www.adomino.net/de/ablauf/.</p>
                            <p>Interessant d&uuml;rfte f&uuml;r Sie vielleicht auch sein, dass die Domain wohnungen.de&nbsp; um 200.000 EUR netto&nbsp; im Dezember 2019 von uns verkauft wurde.</p>
                            <p><br />Mit&nbsp;freundlichen&nbsp;Gr&uuml;&szlig;en<br />Ihr Adomino Team</p>
                            <p>____________________________________</p>
                            <p>DAY Investments Ltd.<br />6 Clayton Street<br />Newmarket<br />Auckland 1023<br />Neuseeland</p>
                            <p>Web: www.adomino.net<br />E-Mail: office@DAY.kiwi<br />Telefon: +64 9 928 1385<br />Telefax : +43 1 333 45 8585</p>
                            <p>Steuernummer: 125-934-966<br />Firmenregister: 6582253</p>
                            <p>Direktoren:<br />Eur. Ing. Harald Hochmann und Tim Johnson</p>
                            </div>',
            'default' => 1,
            'type' => 'invitation',
            'tags' => [ '[[domain]]', '[[anrede-nachname]]', '[[auktion-startzeit]]', '[[auktion-endzeit]]',  '[[auktion-startpreis]]', '[[auktion-endpreis]]',  '[[auktion-tage]]', '[[auktion-schritt]]', '[[vkpreis]]' ],
            'lang' => 'de',
        ]);
        EmailTemplate::create([
            'template_name' => 'Auktion einladen (Englisch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Einladung zur Auktion für die Domain [[domain]]',
            'email_text' => '<p>Content can be saved with saved button at bottom</p>',
            'default' => 0,
            'type' => 'invitation',
            'tags' => [ '[[domain]]', '[[anrede-nachname]]', '[[auktion-startzeit]]', '[[auktion-endzeit]]',  '[[auktion-startpreis]]', '[[auktion-endpreis]]',  '[[auktion-tage]]', '[[auktion-schritt]]', '[[vkpreis]]' ],
            'lang' => 'en',
        ]);

        EmailTemplate::create([
            'template_name' => 'Angebot (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Angebot Domain [[domain]]',
            'email_text' => '<p>[[anredeUndNachname]],</p>
                            <p>zun&auml;chst bedanken wir uns f&uuml;r Ihre Anfrage am Erwerb der Premium-Domain [[domain]].</p>
                            <p>Ganz gleich ob in der Suchmaschine, eine Werbeschaltung bei Google, ein Inserat in einer Zeitung oder Plakatwerbung, der Domainname ist h&auml;ufig die erste Verbindung mit dem zuk&uuml;nftigen Interessenten. Beschreibende Premium-Domainnamen sorgen von Beginn an wie bei einem bekannten Markenprodukt f&uuml;r einen vertrauensw&uuml;rdigen und kompetenten Eindruck. Dadurch lassen sich h&ouml;here Klickraten bei Google AdWords Kampagnen erzielen, die zusammen durch den leicht merkbaren Domainnamen zu geringeren Marketingkosten f&uuml;hren.</p>
                            <p>Wir, die DAY Investments GmbH haben dies bereits im Jahr 1999 erkannt und investieren deshalb selbst seit dem in beschreibende Domainnamen. Dadurch z&auml;hlen wir nun zu den bekanntesten und erfolgreichsten Domaininvestoren im deutschsprachigen Raum mit derzeit &uuml;ber 10.000 Premium-Domains wie autos.de, wohnung.de, werbung.de, fotos.de, webdesign.de oder auch internationale Domains wie witz.com, suchen.com, routenplaner.com oder pda.net. &nbsp;Zu unseren Kunden z&auml;hlen bekannte Firmen wie McDonald&acute;s, Microsoft, Saturn/Media-Markt, Dr. Oetker, SKY, OBI, Stadt Wien, Kraft Foods, Kronen-Zeitung, &nbsp;S&uuml;dwestrundfunk, OE24.at oder Swisscom.</p>
                            <p>Basis unserer automatisierten Domainbewertung f&uuml;r die Premium-Domain [[domain]] sind prim&auml;r das Domainalter, der Eigentraffic der Domain (TypeIns), der Wert des Keywords in Suchmaschinen (Cost per Click) sowie die Anzahl der bisherigen Kaufinteressenten und deren Preisvorstellungen.&nbsp;</p>
                            <p>Unsere Bewertung der Domain [[domain]] ergab einen Wert von [[vkpreis]] Euro (netto). Das Angebot ist 14 Tage g&uuml;ltig. Da wir auch durchwegs mit anderen Interessenten gleichzeitig in Verbindung stehen, k&ouml;nnen wir Ihnen die Domain [[domain]] nur unverbindlich anbieten. (First Come First Serve Prinzip). Irrt&uuml;mer vorbehalten.</p>
                            <p>Gerne k&ouml;nnen Sie uns auch Ihre Preisvorstellung mitteilen, da es sich bei dem genannten Preis um keinen Fixpreis sondern um einen branchen&uuml;blichen Verhandlungsbasis-Preis handelt und wir auch gerne bereit sind, &uuml;ber den Preis mit Ihnen zu sprechen. Falls Ihre Preisvorstellungen weit unter unseren Preisvorstellungen liegen, bieten wir vereinzelt auch eine Domainauktion auf der neu entwickelten Auktionsplattform www.adomino.net an. Falls Sie Kaufinteresse an der Domain [[domain]] haben sollten, reservieren wir auf Anfrage gerne die Domain f&uuml;r maximal 14 Tage.&nbsp;</p>
                            <p>Ich hoffe Ihnen mit diesen Informationen behilflich gewesen zu sein und freue mich auf Ihre Antwort. Bei weiteren Fragen stehe ich Ihnen gerne zur Verf&uuml;gung.</p>
                            <p>Mit freundlichen Gr&uuml;&szlig;en</p>
                            <p>Eur.Ing. Harald Hochmann<br />Gesch&auml;ftsf&uuml;hrer&nbsp;</p>
                            <p>DAY Investments GmbH<br />Millennium Tower, 23. Stock<br />Handelskai 94-96<br />A-1200 Wien<br />&Ouml;sterreich</p>
                            <p>Tel: +43 (1) 333 45 - 8555<br />Fax: +43 (1) 333 45 - 8585<br />Mail: hochmann@day.eu<br />Web: http://www.day.eu</p>
                            <p>UID: AT U57657912<br />FimenbuchNr: FN 242524d, Wien<br />Gerichtsstand: Wien<br />Gesch&auml;ftsf&uuml;hrer: Harald Hochmann, Marcus Hofer</p>',
            'default' => 0,
            'type' => 'offer',
            'tags' =>  [ '[[domain]]', '[[anredeUndNachname]]', '[[vkpreis]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Angebot (Englisch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => "<p>Hello!</p>
                            <p>First of all, we thank you for your request to purchase the premium domain [[domain]].</p>
                            <p>Regardless of whether it is in the search engine, an advertisement on Google, an advertisement in a newspaper or a poster, the domain name is often the first contact with the prospective customer. Generic premium domain names ensure a trustworthy and competent impression right from the start, as with a well-known branded product. As a result, higher click rates can be achieved with Google AdWords campaigns, which together lead to lower marketing costs due to the easily remembered domain name.</p>
                            <p>We recognized this in 1999 and have therefore been investing in generic domain names since then. As a result, we are now one of the best-known and most successful domain investors in German-speaking countries with currently over 10,000 premium domains such as autos.de ,wohnung.de, werbung.de, fotos.de, webdesign.de or international domains such as witz.com .com, routenplaner.com or pda.net. Our customers include well-known companies such as McDonald's, Microsoft, Saturn / Media-Markt, Dr. Oetker, SKY, OBI, City of Vienna, Kraft Foods, Kronen-Zeitung, S&uuml;dwestrundfunk, OE24.at or Swisscom.</p>
                            <p>The basis of our automated domain evaluation for the premium domain [[domain]] is primarily the domain age, the domain's own traffic (Type-Ins), the value of the keyword in search engines (cost per click) as well as the number of previous potential buyers and their price expectations.</p>
                            <p>Our assessment of the [[domain]] domain resulted in a value of [[vkpreis]] Euro (excluding tax). The offer is valid for 14 days. Since we are also in contact with other interested parties at the same time, we can only offer you the [[domain]] domain without obligation. (First Come First Serve principle). Errors excepted.</p>
                            <p>You are also welcome to tell us your asking price, as the price mentioned is not a fixed price but a negotiation base price customary in the industry and we are also happy to talk to you about the price. If your asking price is far below our asking price, we occasionally also offer a domain auction on the newly developed auction platform www.adomino.net. If you are interested in buying the domain [[domain]], we will be happy to reserve the domain on request for a maximum of 14 days.</p>
                            <p>I hope that this information has been helpful to you and I look forward to your reply. For further information do not hesitate to contact me.</p>
                            <p>Best regards,</p>
                            <p>Harald Hochmann<br />Managing Director &nbsp;</p>
                            <p>DAY Investments GmbH<br />Millennium Tower<br />Handelskai 94-96<br />1200 Vienna<br />Austria</p>
                            <p>Tel: +43 (1) 333 45 &ndash; 8555<br />Fax: +43 (1) 333 45 &ndash; 8585<br />Mail: hochmann@day.eu<br />Web: http://www.day.eu</p>",
            'default' => 0,
            'type' => 'offer',
            'tags' =>  [ '[[domain]]', '[[anredeUndNachname]]', '[[vkpreis]]'],
            'lang' => 'en',
        ]);

        EmailTemplate::create([
            'template_name' => 'PIN-Code (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  [ '[[pin-code]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Zertifizierung Level 4 OK (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  null,
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Zertifizierung Level 4 Fehler (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  null,
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Glückwunsch Domainkauf (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]', '[[vkpreis]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Anderer Bieter Domain gekauft (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]', '[[vkpreis]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Anderer Interessent in Watchlist hinzugefügt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Anderer Interessent in Favoriten hinzugefügt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Preis gesenkt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]', '[[aktueller-preis]]', '[[neuer-preis]]'],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Auktionsende kein Bieter (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]', '[[endpreis]]' ],
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Bieter Domain gekauft (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  [ '[[domain]]', '[[vkpreis]]' ],
            'lang' => 'de',
        ]);


        /*
         *
         *
         * EmailTemplate::create([
            'template_name' => 'Auktion einladen (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Einladung zur Auktion für die Premium Domain [[domain]]',
            'email_text' => '<div class="col-sm-2">
                            <p>[[anrede-nachname]],</p>
                            <p>Sie hatten vor einiger Zeit Interesse daran, die Premium Domain [[domain]] auf der Handelsplattform von Adomino zu erwerben. Der Inhaber der Domain hat sich k&uuml;rzlich dazu entschlossen die Domain &uuml;ber unsere neu entwickelte Auktionsplattform versteigern zu lassen.<br /><br />Die Auktion startet am [[auktion-startzeit]] und endet voraussichtlich am [[auktion-endzeit]], sofern kein Bieter die Domain mittels der Sofortkauf-Option vorzeitig kauft.&nbsp; Falls Sie nach wie vor an der Domain [[domain]] interessiert sind, k&ouml;nnte dies Ihre letzte Chance sein, die Domain zu erwerben!<br /><br />Sie m&ouml;chten sich diese Auktion ansehen oder mitbieten? Dann geben Sie einfach www.[[domain]] in Ihren Browser ein. Die Erkl&auml;rung des Auktionsablaufes finden Sie hier: www.adomino.net/de/ablauf/.</p>
                            <p>Interessant d&uuml;rfte f&uuml;r Sie vielleicht auch sein, dass die Domain wohnungen.de&nbsp; um 200.000 EUR netto&nbsp; im Dezember 2019 von uns verkauft wurde.</p>
                            <p><br />Mit&nbsp;freundlichen&nbsp;Gr&uuml;&szlig;en<br />Ihr Adomino Team</p>
                            <p>____________________________________</p>
                            <p>DAY Investments Ltd.<br />6 Clayton Street<br />Newmarket<br />Auckland 1023<br />Neuseeland</p>
                            <p>Web: www.adomino.net<br />E-Mail: office@DAY.kiwi<br />Telefon: +64 9 928 1385<br />Telefax : +43 1 333 45 8585</p>
                            <p>Steuernummer: 125-934-966<br />Firmenregister: 6582253</p>
                            <p>Direktoren:<br />Eur. Ing. Harald Hochmann und Tim Johnson</p>
                            </div>',
            'default' => 1,
            'type' => 'invitation',
            'tags' => json_encode([ '[[domain]]', '[[anrede-nachname]]', '[[auktion-startzeit]]', '[[auktion-endzeit]]',  '[[auktion-startpreis]]', '[[auktion-endpreis]]',  '[[auktion-tage]]', '[[auktion-schritt]]', '[[vkpreis]]' ]),
            'lang' => 'de',
        ]);
        EmailTemplate::create([
            'template_name' => 'Auktion einladen (Englisch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Einladung zur Auktion für die Domain [[domain]]',
            'email_text' => '<p>Content can be saved with saved button at bottom</p>',
            'default' => 0,
            'type' => 'invitation',
            'tags' => json_encode([ '[[domain]]', '[[anrede-nachname]]', '[[auktion-startzeit]]', '[[auktion-endzeit]]',  '[[auktion-startpreis]]', '[[auktion-endpreis]]',  '[[auktion-tage]]', '[[auktion-schritt]]', '[[vkpreis]]' ]),
            'lang' => 'en',
        ]);

        EmailTemplate::create([
            'template_name' => 'Angebot (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Angebot Domain [[domain]]',
            'email_text' => '<p>[[anredeUndNachname]],</p>
                            <p>zun&auml;chst bedanken wir uns f&uuml;r Ihre Anfrage am Erwerb der Premium-Domain [[domain]].</p>
                            <p>Ganz gleich ob in der Suchmaschine, eine Werbeschaltung bei Google, ein Inserat in einer Zeitung oder Plakatwerbung, der Domainname ist h&auml;ufig die erste Verbindung mit dem zuk&uuml;nftigen Interessenten. Beschreibende Premium-Domainnamen sorgen von Beginn an wie bei einem bekannten Markenprodukt f&uuml;r einen vertrauensw&uuml;rdigen und kompetenten Eindruck. Dadurch lassen sich h&ouml;here Klickraten bei Google AdWords Kampagnen erzielen, die zusammen durch den leicht merkbaren Domainnamen zu geringeren Marketingkosten f&uuml;hren.</p>
                            <p>Wir, die DAY Investments GmbH haben dies bereits im Jahr 1999 erkannt und investieren deshalb selbst seit dem in beschreibende Domainnamen. Dadurch z&auml;hlen wir nun zu den bekanntesten und erfolgreichsten Domaininvestoren im deutschsprachigen Raum mit derzeit &uuml;ber 10.000 Premium-Domains wie autos.de, wohnung.de, werbung.de, fotos.de, webdesign.de oder auch internationale Domains wie witz.com, suchen.com, routenplaner.com oder pda.net. &nbsp;Zu unseren Kunden z&auml;hlen bekannte Firmen wie McDonald&acute;s, Microsoft, Saturn/Media-Markt, Dr. Oetker, SKY, OBI, Stadt Wien, Kraft Foods, Kronen-Zeitung, &nbsp;S&uuml;dwestrundfunk, OE24.at oder Swisscom.</p>
                            <p>Basis unserer automatisierten Domainbewertung f&uuml;r die Premium-Domain [[domain]] sind prim&auml;r das Domainalter, der Eigentraffic der Domain (TypeIns), der Wert des Keywords in Suchmaschinen (Cost per Click) sowie die Anzahl der bisherigen Kaufinteressenten und deren Preisvorstellungen.&nbsp;</p>
                            <p>Unsere Bewertung der Domain [[domain]] ergab einen Wert von [[vkpreis]] Euro (netto). Das Angebot ist 14 Tage g&uuml;ltig. Da wir auch durchwegs mit anderen Interessenten gleichzeitig in Verbindung stehen, k&ouml;nnen wir Ihnen die Domain [[domain]] nur unverbindlich anbieten. (First Come First Serve Prinzip). Irrt&uuml;mer vorbehalten.</p>
                            <p>Gerne k&ouml;nnen Sie uns auch Ihre Preisvorstellung mitteilen, da es sich bei dem genannten Preis um keinen Fixpreis sondern um einen branchen&uuml;blichen Verhandlungsbasis-Preis handelt und wir auch gerne bereit sind, &uuml;ber den Preis mit Ihnen zu sprechen. Falls Ihre Preisvorstellungen weit unter unseren Preisvorstellungen liegen, bieten wir vereinzelt auch eine Domainauktion auf der neu entwickelten Auktionsplattform www.adomino.net an. Falls Sie Kaufinteresse an der Domain [[domain]] haben sollten, reservieren wir auf Anfrage gerne die Domain f&uuml;r maximal 14 Tage.&nbsp;</p>
                            <p>Ich hoffe Ihnen mit diesen Informationen behilflich gewesen zu sein und freue mich auf Ihre Antwort. Bei weiteren Fragen stehe ich Ihnen gerne zur Verf&uuml;gung.</p>
                            <p>Mit freundlichen Gr&uuml;&szlig;en</p>
                            <p>Eur.Ing. Harald Hochmann<br />Gesch&auml;ftsf&uuml;hrer&nbsp;</p>
                            <p>DAY Investments GmbH<br />Millennium Tower, 23. Stock<br />Handelskai 94-96<br />A-1200 Wien<br />&Ouml;sterreich</p>
                            <p>Tel: +43 (1) 333 45 - 8555<br />Fax: +43 (1) 333 45 - 8585<br />Mail: hochmann@day.eu<br />Web: http://www.day.eu</p>
                            <p>UID: AT U57657912<br />FimenbuchNr: FN 242524d, Wien<br />Gerichtsstand: Wien<br />Gesch&auml;ftsf&uuml;hrer: Harald Hochmann, Marcus Hofer</p>',
            'default' => 0,
            'type' => 'offer',
            'tags' =>  json_encode([ '[[domain]]', '[[anredeUndNachname]]', '[[vkpreis]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Angebot (Englisch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => "<p>Hello!</p>
                            <p>First of all, we thank you for your request to purchase the premium domain [[domain]].</p>
                            <p>Regardless of whether it is in the search engine, an advertisement on Google, an advertisement in a newspaper or a poster, the domain name is often the first contact with the prospective customer. Generic premium domain names ensure a trustworthy and competent impression right from the start, as with a well-known branded product. As a result, higher click rates can be achieved with Google AdWords campaigns, which together lead to lower marketing costs due to the easily remembered domain name.</p>
                            <p>We recognized this in 1999 and have therefore been investing in generic domain names since then. As a result, we are now one of the best-known and most successful domain investors in German-speaking countries with currently over 10,000 premium domains such as autos.de ,wohnung.de, werbung.de, fotos.de, webdesign.de or international domains such as witz.com .com, routenplaner.com or pda.net. Our customers include well-known companies such as McDonald's, Microsoft, Saturn / Media-Markt, Dr. Oetker, SKY, OBI, City of Vienna, Kraft Foods, Kronen-Zeitung, S&uuml;dwestrundfunk, OE24.at or Swisscom.</p>
                            <p>The basis of our automated domain evaluation for the premium domain [[domain]] is primarily the domain age, the domain's own traffic (Type-Ins), the value of the keyword in search engines (cost per click) as well as the number of previous potential buyers and their price expectations.</p>
                            <p>Our assessment of the [[domain]] domain resulted in a value of [[vkpreis]] Euro (excluding tax). The offer is valid for 14 days. Since we are also in contact with other interested parties at the same time, we can only offer you the [[domain]] domain without obligation. (First Come First Serve principle). Errors excepted.</p>
                            <p>You are also welcome to tell us your asking price, as the price mentioned is not a fixed price but a negotiation base price customary in the industry and we are also happy to talk to you about the price. If your asking price is far below our asking price, we occasionally also offer a domain auction on the newly developed auction platform www.adomino.net. If you are interested in buying the domain [[domain]], we will be happy to reserve the domain on request for a maximum of 14 days.</p>
                            <p>I hope that this information has been helpful to you and I look forward to your reply. For further information do not hesitate to contact me.</p>
                            <p>Best regards,</p>
                            <p>Harald Hochmann<br />Managing Director &nbsp;</p>
                            <p>DAY Investments GmbH<br />Millennium Tower<br />Handelskai 94-96<br />1200 Vienna<br />Austria</p>
                            <p>Tel: +43 (1) 333 45 &ndash; 8555<br />Fax: +43 (1) 333 45 &ndash; 8585<br />Mail: hochmann@day.eu<br />Web: http://www.day.eu</p>",
            'default' => 0,
            'type' => 'offer',
            'tags' =>  json_encode([ '[[domain]]', '[[anredeUndNachname]]', '[[vkpreis]]']),
            'lang' => 'en',
        ]);

        EmailTemplate::create([
            'template_name' => 'PIN-Code (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  json_encode([ '[[pin-code]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Zertifizierung Level 4 OK (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  null,
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Zertifizierung Level 4 Fehler (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'registration',
            'tags' =>  null,
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Glückwunsch Domainkauf (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]', '[[vkpreis]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Anderer Bieter Domain gekauft (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]', '[[vkpreis]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Anderer Interessent in Watchlist hinzugefügt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Anderer Interessent in Favoriten hinzugefügt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Preis gesenkt (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' => json_encode([ '[[domain]]', '[[aktueller-preis]]', '[[neuer-preis]]']),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Auktionsende kein Bieter (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]', '[[endpreis]]' ]),
            'lang' => 'de',
        ]);

        EmailTemplate::create([
            'template_name' => 'Watchlist - Bieter Domain gekauft (Deutsch)',
            'sender_name' => 'DAY Investments GmbH',
            'sender_email' => 'office@adomino.net',
            'bcc' => 'cc@day.eu',
            'email_subject' => 'Offer domain [[domain]]',
            'email_text' => '',
            'default' => 0,
            'type' => 'auction',
            'tags' =>  json_encode([ '[[domain]]', '[[vkpreis]]' ]),
            'lang' => 'de',
        ]);

        */
    }
}
