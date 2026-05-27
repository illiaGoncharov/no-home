#!/bin/bash

# NO HOME - Deploy Script
# Usage: ./deploy.sh [prod|staging]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration - РЕАЛЬНЫЕ ДАННЫЕ ДЛЯ NOHOME.CLOUD
PROD_HOST="91.108.101.5"
PROD_USER="u818822023"
PROD_PASS="ftp3000NoHome!"
PROD_PATH="/public_html/wp-content/themes/blankslate/"

# Для staging (если есть)
STAGING_HOST="91.108.101.5"
STAGING_USER="u818822023" 
STAGING_PASS="ftp3000NoHome!"
STAGING_PATH="/public_html/wp-content/themes/blankslate/"

# Files to deploy - ТОЛЬКО НЕОБХОДИМЫЕ ДЛЯ ПРОДАКШНА
FILES_TO_DEPLOY=(
    "js/horse-text-handler.js"
    "header.php" 
    "style.css"
    "functions.php"
)

# Mobile files - всё что нужно для мобайла
MOBILE_FILES=(
    "functions.php"
    "header.php"
    "footer.php"
    "css/mobile.css"
    "js/mobile.js"
    "mobile/mobile.php"
    "mobile/header-mobile.php"
    "mobile/footer-mobile.php"
    "mobile/pages/home.php"
    "files/mobile/home/skeleton-bottom.png"
    "files/mobile/home/arrow-left.png"
    "files/mobile/home/arrow-right.png"
    "files/mobile/home/red-horse-running-text.png"
)

# Image files - картинки пультика (все варианты)
IMAGE_FILES=(
    "files/remote-control/пультик.png"
    "files/remote-control/пультик-плеер.png" 
    "files/remote-control/пауза.png"
    "files/remote-control/remote-default.png"
    "files/remote-control/remote-player.png"
    "files/remote-control/pause-button.png"
    "files/remote-control/README.md"
)

# Development files - НЕ деплоим на продакшн
DEV_FILES=(
    "[local]*.php"
    "README*.md"
    "QUICK_TEST.md"
    "IMAGES_PIPELINE.md"
    "deploy.sh"
    ".gitignore"
)

function deploy_to_server() {
    local HOST=$1
    local USER=$2
    local PASS=$3
    local PATH=$4
    local ENV=$5
    local FILES=$6
    
    echo -e "${YELLOW}🚀 Deploying to $ENV...${NC}"
    
    # Проверяем наличие lftp
    if ! command -v lftp &> /dev/null && ! [ -f "/opt/homebrew/bin/lftp" ]; then
        echo -e "${RED}❌ lftp не найден. Устанавливаем...${NC}"
        if [[ "$OSTYPE" == "darwin"* ]]; then
            # macOS
            if command -v brew &> /dev/null; then
                brew install lftp
            else
                echo -e "${RED}❌ Установите Homebrew или lftp вручную${NC}"
                exit 1
            fi
        else
            # Linux
            sudo apt-get install lftp -y || sudo yum install lftp -y
        fi
    fi
    
    # Определяем путь к lftp
    LFTP_CMD="lftp"
    if [ -f "/opt/homebrew/bin/lftp" ]; then
        LFTP_CMD="/opt/homebrew/bin/lftp"
    fi
    
    # Если передан массив (reference)
    if [[ $FILES == *"[@]" ]]; then
        eval "local file_list=(\"\${$FILES}\")"
    else
        # Если передан один файл
        local file_list=("$FILES")
    fi
    
    for file in "${file_list[@]}"; do
        if [ -f "$file" ]; then
            echo -e "${GREEN}📤 Uploading $file${NC}"
            
            # Создаем директорию если нужно (только если файл в поддиректории)
            DIR="${file%/*}"
            if [[ "$file" == */* ]]; then
                $LFTP_CMD -c "
                set ftp:ssl-allow no
                set ftp:passive-mode on
                open -u $USER,$PASS $HOST
                cd $PATH
                mkdir -pf $DIR
                bye
                "
            fi
            
            # Загружаем файл (с явным указанием пути назначения)
            $LFTP_CMD -c "
            set ftp:ssl-allow no
            set ftp:passive-mode on
            open -u $USER,$PASS $HOST
            cd $PATH
            put '$file' -o '$file'
            bye
            "
            
            if [ $? -eq 0 ]; then
                echo -e "${GREEN}✅ $file uploaded successfully${NC}"
            else
                echo -e "${RED}❌ Failed to upload $file${NC}"
            fi
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
            deploy_to_server $PROD_HOST $PROD_USER $PROD_PASS $PROD_PATH "PRODUCTION" FILES_TO_DEPLOY[@]
        else
            echo -e "${RED}❌ Deployment cancelled${NC}"
        fi
        ;;
    "images")
        echo -e "${YELLOW}🖼️ IMAGES ONLY DEPLOYMENT${NC}"
        deploy_to_server $PROD_HOST $PROD_USER $PROD_PASS $PROD_PATH "PRODUCTION (IMAGES)" IMAGE_FILES[@]
        ;;
    "code")
        echo -e "${YELLOW}💻 CODE ONLY DEPLOYMENT${NC}"
        deploy_to_server $PROD_HOST $PROD_USER $PROD_PASS $PROD_PATH "PRODUCTION (CODE)" FILES_TO_DEPLOY[@]
        ;;
    "staging"|"stage")
        echo -e "${YELLOW}🧪 STAGING DEPLOYMENT${NC}"
        deploy_to_server $STAGING_HOST $STAGING_USER $STAGING_PASS $STAGING_PATH "STAGING" FILES_TO_DEPLOY[@]
        ;;
    "mobile")
        echo -e "${YELLOW}📱 MOBILE DEPLOYMENT${NC}"
        deploy_to_server $PROD_HOST $PROD_USER $PROD_PASS $PROD_PATH "PRODUCTION (MOBILE)" MOBILE_FILES[@]
        ;;
    "hotfix")
        echo -e "${YELLOW}🔥 HOTFIX DEPLOYMENT (JS only)${NC}"
        deploy_to_server $PROD_HOST $PROD_USER $PROD_PASS $PROD_PATH "HOTFIX" "js/horse-text-handler.js"
        ;;
    *)
        echo -e "${YELLOW}Usage: ./deploy.sh [prod|images|code|staging|hotfix]${NC}"
        echo -e "${YELLOW}Commands:${NC}"
        echo -e "  ${GREEN}./deploy.sh prod${NC}     - Deploy code to production"
        echo -e "  ${GREEN}./deploy.sh images${NC}   - Deploy only images"
        echo -e "  ${GREEN}./deploy.sh code${NC}     - Deploy only code files" 
        echo -e "  ${GREEN}./deploy.sh staging${NC}  - Deploy to staging"
        echo -e "  ${GREEN}./deploy.sh hotfix${NC}   - Deploy only JS (quick fix)"
        echo
        echo -e "${YELLOW}Files that will be deployed:${NC}"
        echo -e "${GREEN}CODE FILES:${NC}"
        for file in "${FILES_TO_DEPLOY[@]}"; do
            echo -e "  - $file"
        done
        echo -e "${GREEN}IMAGE FILES:${NC}"
        for file in "${IMAGE_FILES[@]}"; do
            echo -e "  - $file"
        done
        echo
        echo -e "${YELLOW}Files that WON'T be deployed:${NC}"
        for file in "${DEV_FILES[@]}"; do
            echo -e "  - $file"
        done
        ;;
esac 