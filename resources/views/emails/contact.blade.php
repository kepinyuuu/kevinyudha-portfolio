<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan Baru dari Kontak Portfolio</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #222; margin: 0; padding: 24px; background-color: #f7f7f7;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; padding: 32px; border: 1px solid #e5e5e5;">
        <h2 style="margin-top: 0; color: #111; font-size: 20px; border-bottom: 1px solid #eee; padding-bottom: 12px;">Pesan Baru dari Formulir Kontak</h2>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <tr>
                <td style="padding: 6px 0; color: #666; width: 100px; font-weight: 600;">Nama:</td>
                <td style="padding: 6px 0; color: #111;">{{ $senderName }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #666; font-weight: 600;">Email:</td>
                <td style="padding: 6px 0; color: #111;"><a href="mailto:{{ $senderEmail }}" style="color: #2563eb; text-decoration: none;">{{ $senderEmail }}</a></td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #666; font-weight: 600;">Subjek:</td>
                <td style="padding: 6px 0; color: #111;">{{ $messageSubject }}</td>
            </tr>
        </table>

        <div style="background: #f9f9f9; border-left: 4px solid #2563eb; padding: 16px; border-radius: 4px; margin-top: 16px;">
            <p style="margin: 0; font-weight: 600; color: #444; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Isi Pesan:</p>
            <p style="margin: 0; white-space: pre-wrap; word-break: break-word; color: #222;">{{ $messageBody }}</p>
        </div>

        <p style="margin-top: 32px; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 16px;">
            Email ini dikirimkan melalui formulir kontak portfolio Kevin Yudha Pratama. Anda dapat membalas langsung email ini untuk menghubungi pengirim.
        </p>
    </div>
</body>
</html>

