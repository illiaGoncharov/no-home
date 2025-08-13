#!/bin/bash

# NO HOME - Deploy Script
# Usage: ./deploy.sh [prod|staging]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration (add your FTP credentials)
PROD_HOST="your-production-host.com"
PROD_USER="your-ftp-username"
PROD_PATH="/public_html/wp-content/themes/blankslate/"

STAGING_HOST="your-staging-host.com"
STAGING_USER="your-ftp-username"
STAGING_PATH="/staging/wp-content/themes/blankslate/"

# Files to deploy
FILES_TO_DEPLOY=(
    "js/horse-text-handler.js"
    "[local]main.php"
    "header.php"
    "style.css"
    "REMOTE_CONTROL_TEXTS.md"
)

function deploy_to_server() {
    local HOST=$1
    local USER=$2
    local PATH=$3
    local ENV=$4
    
    echo -e "${YELLOW}🚀 Deploying to $ENV...${NC}"
    
    for file in "${FILES_TO_DEPLOY[@]}"; do
        if [ -f "$file" ]; then
            echo -e "${GREEN}📤 Uploading $file${NC}"
            # Using scp (you can replace with rsync or lftp)
            scp "$file" "$USER@$HOST:$PATH$file"
        else
            echo -e "${RED}❌ File not found: $file${NC}"
        fi
    done
    
    echo -e "${GREEN}✅ Deployment to $ENV completed!${NC}"
}

# Main deployment logic
case $1 in
    "prod"|"production")
        echo -e "${YELLOW}🔥 PRODUCTION DEPLOYMENT${NC}"
        read -p "Are you sure you want to deploy to PRODUCTION? (y/N): " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            deploy_to_server $PROD_HOST $PROD_USER $PROD_PATH "PRODUCTION"
        else
            echo -e "${RED}❌ Deployment cancelled${NC}"
        fi
        ;;
    "staging"|"stage")
        echo -e "${YELLOW}🧪 STAGING DEPLOYMENT${NC}"
        deploy_to_server $STAGING_HOST $STAGING_USER $STAGING_PATH "STAGING"
        ;;
    *)
        echo -e "${YELLOW}Usage: ./deploy.sh [prod|staging]${NC}"
        echo -e "${YELLOW}Commands:${NC}"
        echo -e "  ${GREEN}./deploy.sh staging${NC} - Deploy to staging server"
        echo -e "  ${GREEN}./deploy.sh prod${NC}    - Deploy to production server"
        echo
        echo -e "${YELLOW}Before first use:${NC}"
        echo -e "1. Edit this script and add your FTP credentials"
        echo -e "2. Make executable: ${GREEN}chmod +x deploy.sh${NC}"
        echo -e "3. Test with staging first"
        ;;
esac 