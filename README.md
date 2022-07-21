# Tukalio
## 1. To setup/run backend containers execute:

```bash
sh install.sh
```

Then, your app is under address:
http://6.1.0.2/

When using windows WSL, your app can be found under:
http://localhost

## 2. If you want to run front app, type:

```bash
docorr yarn dev
```

## 3. Executing tests locally
When backend containers are running:
```bash
sh backend/phpunit.sh ./tests
sh backend/phpstan.sh
```
