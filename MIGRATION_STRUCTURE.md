# Modern Migration Structure

This repository now includes the baseline folder structure for migrating the existing PHP attendance system into a modern React + Express architecture.

## Folder Layout

```text
client/
  src/
    components/
    context/
    pages/
    routes/
    services/
    styles/
server/
  src/
    config/
    controllers/
      auth/
    db/
    middleware/
    routes/
      auth/
    services/
    utils/
    validators/
```

## Key Notes

- `server/src` is prepared for clean API layer development (routes -> controllers -> services -> DB).
- `client/src` is prepared for reusable React component development with route-level pages.
- JWT middleware and auth flow stubs are included as the replacement for PHP sessions.
- Existing MySQL schema can be reused by updating SQL queries inside controllers/services.

## Next Module Workflow

For each provided PHP module:
1. Analyze feature behavior and database dependencies.
2. Build backend REST endpoints in `server/src/routes` and `server/src/controllers`.
3. Build frontend pages/components in `client/src/pages` and `client/src/components`.
4. Integrate API calls through `client/src/services/api.js`.
