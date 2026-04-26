# Lessons

## Project Rules
- Re-read `AGENTS.md` when the user says it changed or when starting a new non-trivial task.
- Treat `AGENTS.md` as the full working agreement for this repo and apply all relevant sections, not just the planning subset.
- Follow the `Task Management` section by writing the plan first in `tasks/todo.md`, tracking progress there, documenting review results there, and checking in before implementation on non-trivial tasks.
- Follow the `Core Principles` section by preferring the simplest correct change, finding root causes instead of shortcuts, and minimizing code impact.
- Follow the `Autonomous Bug Fixing` section by investigating evidence, fixing the issue directly, and avoiding unnecessary back-and-forth when the problem can be solved from local context.
- For non-trivial tasks, write a checklist plan in `tasks/todo.md` before implementation.
- Do not mark work complete without verification appropriate to the change.
- For non-trivial work, explicitly apply `AGENTS.md` sections "Verification Before Done" and "Demand Elegance (Balanced)" before closing the task.

## Corrections
- User reminder: do not only follow the planning workflow; also explicitly follow `AGENTS.md` sections "Verification Before Done" and "Demand Elegance (Balanced)" on every relevant task.
- User reminder: apply all relevant instructions from `AGENTS.md` for this repo, not only selected items. 
- User reminder: explicitly follow the `Task Management` and `Core Principles` sections from `AGENTS.md`.
- User reminder: explicitly follow the `Autonomous Bug Fixing` section from `AGENTS.md`.
- When adding create-page media uploads, optimize for bulk upload UX by placing the section after the core fields and configuring the uploader for obvious multi-file behavior instead of single-item editing.
- When the user asks for navigation back to `index.blade.php` or the store, map that request to the frontend `home` route, not the Filament resource index.
- When the user asks for a shortcut that should be reachable from anywhere in admin, implement it at the panel/topbar level instead of page-specific actions.
- For homepage composition changes, follow the narrative order requested by the user exactly instead of assuming the first elegant placement is the desired one.
- For homepage brand sections, avoid oversized headline blocks that dominate the layout; prioritize restrained hierarchy, shorter copy, and cleaner spacing for elegance.
- For adjacent homepage sections in the same visual story, keep their background tone and transition language aligned so the page does not feel visually broken between blocks.
- When two homepage sections are meant to read as one continuous story, prefer a shared wrapper background over two separate sections with duplicated background styles.
- For elegance-focused homepage sections, prefer quieter supporting patterns like editorial lists, slimmer badges, and softer panel contrast over multiple boxed elements with equal visual weight.
- For inputs with absolutely positioned icons, use an explicit component class for icon spacing instead of relying only on utility padding so placeholder text cannot be overlapped.
- When the user promotes a key search interaction to the global header, remove redundant page-level search inputs and preserve the same query through related filter forms with hidden fields.
- For quick-pick inventory filters like mileage, prefer preset buttons over raw min/max numeric inputs while keeping the underlying query parameters compatible with existing filtering logic.
- For AJAX-driven filters, do not rely on Blade-only conditional rendering for controls like "clear filters"; keep the control mounted and sync its visible/disabled state in JavaScript.
- For search UX, do not force one global pattern across all pages when the user wants different behavior per route; keep homepage discovery search and inventory search as distinct experiences when requested.
- When two light-brand homepage sections like About and FAQ should feel continuous, merge them under one shared wrapper background instead of trying to match them with separate section backgrounds.
- For admin theme refinements, keep Filament colors aligned with the storefront identity: black or white surfaces with red gradients, not amber/orange or slate-blue dashboard styling.
