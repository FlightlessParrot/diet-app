import { toValue } from "vue";

export function useTranslateServicesLabel(serviceName)
{
    const getServiceLabel = function (name) {
        switch (name) {
            case "mobile":
                return "z dojazdem";
            case "stationary":
                return "stacjonarnie";
            default:
                return "online";
        }
    };
    
    return getServiceLabel(toValue(serviceName));

}