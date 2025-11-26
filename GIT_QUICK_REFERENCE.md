# Git Quick Reference - TryHackMe SQL Injection Lab

**Last Updated**: November 26, 2025  
**Repository**: https://github.com/AdithyaNaikk/tryhackme-sqli-lab

---

## Quick Commands for Future Updates

### Check Status
```bash
cd /home/adithya/Documents/tryhackme-sqli-lab
git status                          # See changed files
git log --oneline -5                # View recent commits
git diff                            # See all changes
```

### Stage and Commit
```bash
# Stage specific files
git add file1.txt file2.txt

# Or stage all changes
git add .

# Create commit with message
git commit -m "Your commit message here"

# Push to GitHub
git push origin main
```

### View Changes
```bash
git diff app/index.php              # See changes in specific file
git log --oneline                   # View commit history
git show <commit-hash>              # View specific commit
```

### If You Made a Mistake
```bash
# Undo staged changes (before commit)
git restore --staged filename.txt

# Undo local changes (before commit)
git restore filename.txt

# View previous commits
git log --oneline

# Revert to previous commit (creates new commit)
git revert <commit-hash>

# Push the revert
git push origin main
```

---

## Safe Update Checklist

Before pushing to GitHub, always:

- [ ] Test code locally: `docker-compose up --build`
- [ ] Check syntax errors: PHP files validated
- [ ] Review changes: `git diff` before commit
- [ ] Use descriptive commit message
- [ ] Push to `main` branch (not master)
- [ ] Verify on GitHub after push

---

## Common Scenarios

### Adding a New Feature
```bash
git add .                                    # Stage all changes
git commit -m "Feature: [describe what]"     # Commit
git push origin main                         # Push
```

### Fixing a Bug
```bash
git add app/index.php                        # Stage fixed file
git commit -m "Fix: [describe issue]"        # Commit
git push origin main                         # Push
```

### Updating Documentation
```bash
git add README.md GUIDE.md                   # Stage doc files
git commit -m "Docs: [describe changes]"     # Commit
git push origin main                         # Push
```

### Emergency Revert
```bash
git log --oneline                            # Find commit to revert to
git revert <commit-hash>                     # Creates reverse commit
git push origin main                         # Push the revert
```

---

## Branch Information

- **Main Branch**: `main` (production-ready code)
- **Current Branch**: `main` (always push here)
- **Remote**: `origin` (GitHub)

---

## Important Notes

✅ **Safe to Use**:
- `git add` - stages files for commit
- `git commit` - creates local commit
- `git push` - sends to GitHub
- `git revert` - undoes with new commit

❌ **Avoid**:
- `git push --force` - can overwrite others' work
- `git reset --hard` - deletes work permanently
- `git rebase` - rewrites history (unless alone)

---

## Getting Help

```bash
git --help                          # General help
git commit --help                   # Commit help
git push --help                     # Push help
git status                          # Current status
```

---

## After You Push

Your changes will be visible on GitHub in ~30 seconds:
```
https://github.com/AdithyaNaikk/tryhackme-sqli-lab
```

Check:
1. Code tab - see updated files
2. Commits tab - see your new commit
3. Pull requests tab - for any open reviews

---

**Remember**: Always test locally before pushing to GitHub!
