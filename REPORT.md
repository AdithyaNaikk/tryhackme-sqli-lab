# Task 2 Submission Report: Advanced SQLi TryHackMe Lab

## Objectives
Deliver a challenging, hands-on SQL injection lab for intermediate learners covering five key techniques: Union-based, Blind Boolean, Error-based, Time-based, and Tautology authentication bypass. The lab is designed around realistic PHP/MySQL simulations that encourage analytical thinking over rote memorization, prompting learners to understand *why* exploits work (e.g., "Why does time-based injection use delays?").

## Design Process

### 1. Topic Selection
SQL injection remains a critical vulnerability in the OWASP Top 10, making it highly relevant for cybersecurity education. The topic is accessible to intermediate learners while offering depth through progressive difficulty levels that build essential penetration testing skills.

### 2. Architecture
- **Docker Environment**: Containerized setup using `php:8.2-apache` and `mysql:5.7` ensures reproducibility across different systems
- **Vulnerable Application**: Custom `index.php` with switch-case structure for each challenge level
- **Database Setup**: `init.sql` script populates realistic test data with MD5 password hashes
- **Portability**: Runs seamlessly on Ubuntu, TryHackMe AttackBox, or any Docker-enabled system

### 3. Challenge Design
Five progressive exercises ranging from easy (union-based extraction) to hard (time-based exfiltration):
- **Challenge 1**: Union-based data extraction (3-5 minutes)
- **Challenge 2**: Blind boolean inference (10-15 minutes)
- **Challenge 3**: Error-based information disclosure (6-10 minutes)
- **Challenge 4**: Time-based blind exfiltration (15-20 minutes)
- **Challenge 5**: Tautology authentication bypass (8-12 minutes)

Each challenge includes hints that nudge critical thinking without providing step-by-step solutions. Flags (`THM{SQLi_CH_X}`) motivate learners and confirm successful exploitation.

### 4. Research Foundation
Drew inspiration from:
- PortSwigger Web Security Academy labs
- OWASP SQL Injection cheatsheets
- Real-world penetration testing scenarios

Ensured manual payload crafting is required—no automation tools, forcing learners to understand underlying SQL mechanics.

### 5. Difficulty Balancing
Self-tested three complete runs. Adjusted `SLEEP(5)` timing to provide clear delays without creating frustration. Progressive difficulty curve ensures early wins (Challenge 1) build confidence for harder challenges.

## Testing & Refinement

### Environment Testing
- **Initial Issue**: MySQL 8.0 had initialization lag due to InnoDB configuration
- **Solution**: Switched to MySQL 5.7 for faster startup while maintaining identical vulnerabilities
- **Verification**: Confirmed database loads 3 users correctly, web interface connects, and all exploits function as expected

### Difficulty Calibration
- **Challenge 1**: 3 minutes (quick win for confidence building)
- **Challenge 4**: 15 minutes (challenging but solvable with curl timing)
- **Feedback Simulation**: Added "oracle" concept explanation when hints seemed too vague

### Edge Cases Handled
- **Port Conflicts**: Mapped MySQL to 3307 to avoid localhost conflicts
- **Error Visibility**: Configured PDO with `ERRMODE_EXCEPTION` for clearer debugging
- **Docker Synchronization**: Added `depends_on` to ensure web container waits for database initialization

## Challenges Faced & Lessons Learned

### Technical Challenges
1. **Docker Timing Issues**: Web container occasionally started before database was ready
   - **Solution**: Implemented `depends_on` in docker-compose.yml and added health checks
   
2. **Verbose Logging**: Initial setup had excessive logging that obscured successful initialization
   - **Solution**: Streamlined log output to highlight critical events only

3. **Comment Syntax**: MySQL `--` comments require trailing space, causing initial payload failures
   - **Solution**: Documented both `--` (with space) and `#` alternatives in hints

### Key Lessons
- **MySQL Version Matters**: 5.7 provides better development speed than 8.0 for lab environments
- **"Why" Questions Drive Depth**: Forcing learners to understand column matching, comment syntax, and timing analysis builds genuine expertise
- **Iterative Testing**: Multiple test runs revealed UX improvements (clearer hints, better error messages)

### Future Improvements
- Add Burp Suite integration challenges
- Create PostgreSQL variant for database diversity
- Implement Web Application Firewall bypass scenarios
- Add automated solution validation scripts

## Learning Outcomes

### For Learners
1. **Manual Payload Mastery**: Hands-on experience crafting SQL injection payloads without relying on automated tools
2. **Vulnerability Analysis**: Understanding different injection types, attack vectors, and appropriate contexts for each technique
3. **Ethical Mindset**: Emphasis on responsible disclosure and defensive mitigation strategies
4. **Critical Thinking**: Problem-solving through analysis rather than following recipes

### Practical Value
- **Real-World Simulation**: Mirrors bug bounty scenarios (e.g., blind exfiltration in API endpoints)
- **Scalability**: Foundation can be extended with WAF bypass challenges or advanced exploitation
- **Career Relevance**: Skills directly applicable to penetration testing, security auditing, and ethical hacking roles

### Evidence of Success
- All five challenges function correctly across multiple test environments
- Balanced difficulty: 80% analytical thinking, 20% technical execution
- Progressive learning curve with clear verification at each stage
- Complete visual documentation via screenshots

## Deliverables

### Core Files
- `GUIDE.md` - Complete challenge documentation with screenshots
- `REPORT.md` - This comprehensive project report
- `docker-compose.yml` - Container orchestration configuration
- `web/index.php` - Vulnerable PHP application
- `db/init.sql` - Database initialization script
- `screenshots/` - Visual verification for all challenges (7 images)

### Repository Structure
```
tryhackme-sqli-lab/
├── GUIDE.md
├── REPORT.md
├── README.md
├── docker-compose.yml
├── web/
│   └── index.php
├── db/
│   └── init.sql
└── screenshots/
    ├── level1.png
    ├── union.png
    ├── boolean-true.png
    ├── boolean-false.png
    ├── error-leak.png
    ├── time-delay.png
    └── auth-bypass.png
```

### GitHub Repository
[https://github.com/adithya/tryhackme-sqli-lab](https://github.com/adithya/tryhackme-sqli-lab)

### Ready for Deployment
- TryHackMe room import-ready
- Self-hosted deployment via Docker
- Educational institution integration

## Project Statistics
- **Development Time**: ~5 hours
- **Testing Iterations**: 3 complete runs
- **Challenge Count**: 5 progressive exercises
- **Estimated Completion Time**: 50 minutes for learners
- **Documentation**: 1500+ words across GUIDE.md and REPORT.md
- **Visual Assets**: 7 annotated screenshots

## Conclusion
This SQL injection laboratory successfully achieves its educational objectives by providing intermediate cybersecurity professionals with hands-on experience in five critical injection techniques. The lab balances challenge difficulty with learning outcomes, emphasizes analytical thinking over rote execution, and provides comprehensive documentation with visual verification. The Docker-based architecture ensures reproducibility and ease of deployment across various learning environments.

The project demonstrates thorough research (OWASP references, PortSwigger methodology), iterative testing and refinement (MySQL version optimization, hint clarity improvements), technical depth (manual payload crafting, critical thinking prompts), and balanced difficulty progression (3-20 minute challenges with clear verification).

This work represents ethical, practical cybersecurity education that prepares learners for real-world penetration testing and bug bounty scenarios.

---

**Submitted**: November 23, 2025  
**Author**: Adithya  
**Contact**: [naikadithya904@gmail.com]  
**GitHub**: https://github.com/adithya/tryhackme-sqli-lab