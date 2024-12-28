export const useSocialMediaIcons=(socialMediaModel)=>
{   
        switch(socialMediaModel.type)
        {
        case 'x':
            return 'twitter';
        case 'tiktok':
            return 'tiktok';
        case 'strona internetowa':
            return 'external-link';
        default:
            return socialMediaModel.type;
        }
}