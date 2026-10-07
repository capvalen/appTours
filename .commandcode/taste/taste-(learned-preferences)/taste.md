# Taste (learned preferences)
- Loads secrets (e.g. salt) from a `.env` file instead of hardcoding them in source code. Confidence: 0.9
- Prefers dependency-free / minimal solutions over installing external packages (e.g. built a small custom `.env` loader instead of pulling in vlucas/phpdotenv). Confidence: 0.75
- Protects `.env` files from both Git (`.gitignore`) and web access (`.htaccess` / nginx dotfile deny). Confidence: 0.8
- Provides a `.env.example` template with instructions so config can be reproduced without leaking secrets. Confidence: 0.75
- Verifies every PHP change with `php -l` linting plus a roundtrip functional test (e.g. encrypt/decrypt cycle). Confidence: 0.75
- Generates random secrets using PHP-native functions (`random_bytes` / `bin2hex`). Confidence: 0.65
