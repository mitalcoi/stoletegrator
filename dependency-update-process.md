##

- Основной проект: `my-app/`
- Зависимая библиотека: `vendor-name/my-lib`
- Исходники библиотеки: `https://github.com/vendor-name/my-lib` (пример)

---

### Клонирование и работа в отдельной ветке

```bash
git clone git@github.com:vendor-name/my-lib.git
cd my-lib
git checkout -b feature/fix-something
```

---

### Вносим изменения

```bash
git add src/Foo.php
git commit -m "fix: correct logic in Foo class"
git push origin feature/fix-something
```

### Подключаем изменения

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/vendor-name/my-lib"
        }
    ],
    "require": {
        "vendor-name/my-lib": "dev-feature/fix-something"
    }
}
```

### Обвновляем
```
composer update vendor-name/my-lib
```

### Релиз библиотеки
```bash
cd my-lib
git checkout main
git merge feature/fix-something
git tag v1.2.3
git push origin main --tags
```
### Обновление зависимости в проекте
```json
{
    "require": {
        "vendor-name/my-lib": "^1.2.3"
    }
}
```

### Деплой
```
git add .
git commit -m "chore: bump my-lib to v1.2.3"
git push origin main
```
## Выгружаем через обычный bash-скрипт. В реальном мире может быть CI/CD + Kubernetes, Ansible
```
ssh user@prod-server
cd /var/www/my-app
git pull
composer install --no-dev --optimize-autoloader
php bin/console doctrine:migrations:migrate
```
