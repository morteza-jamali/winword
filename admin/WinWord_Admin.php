<?php
    namespace WinWord\Admin;

    use WinWord\App\App;
    use WinWordCore\App\Config;
    use WinWordCore\App\View;

    class WinWord_Admin {
        private $plugin_name;
        private $version;

        public function __construct($plugin_name, $version) {
            $this->plugin_name = $plugin_name;
            $this->version = $version;
        }

        public function register_styles() {
            global $hook_suffix;

            if(in_array($hook_suffix , array(
                'toplevel_page_winword'
            ))) {
                foreach(Config::getDefault('styles') as $name => $src) {
                    wp_register_style($this->plugin_name . '-' . $name ,
                        $src ,
                        array(), $this->version, 'all');
                    wp_enqueue_style($this->plugin_name . '-' . $name);
                }
            }
        }

        public function register_scripts() {
            global $hook_suffix;

            if(in_array($hook_suffix , array(
                'toplevel_page_winword'
            ))) {
                foreach(Config::getDefault('scripts') as $name => $src) {
                    wp_register_script($this->plugin_name . '-' . $name,
                        $src ,
                        array('jquery'),
                        $this->version, true);
                    wp_enqueue_script($this->plugin_name . '-' . $name);
                }
            }
        }

        public function displayView() {
            View::display('main' , [
                'apps' => (new App())->apps
            ]);
        }

        public function add_menu() {
            add_menu_page(
                'WinWord management',
                'WinWord',
                'administrator',
                'winword',
                array($this , 'displayView') ,
                'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiIHdpZHRoPSI2MDBweCIgaGVpZ2h0PSI2MDBweCIgdmlld0JveD0iMCAwIDYwMCA2MDAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDYwMCA2MDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPiAgPGltYWdlIGlkPSJpbWFnZTAiIHdpZHRoPSI2MDAiIGhlaWdodD0iNjAwIiB4PSIwIiB5PSIwIgogICAgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9wbmc7YmFzZTY0LGlWQk9SdzBLR2dvQUFBQU5TVWhFVWdBQUFsZ0FBQUpZQ0FRQUFBQVViMUJYQUFBQUJHZEJUVUVBQUxHUEMveGhCUUFBQUNCalNGSk4KQUFCNkpnQUFnSVFBQVBvQUFBQ0E2QUFBZFRBQUFPcGdBQUE2bUFBQUYzQ2N1bEU4QUFBQUFtSkxSMFFBLzRlUHpMOEFBQUFIZEVsTgpSUWZqREFNVEJqanJlWU5TQUFCQVQwbEVRVlI0MnUzZGFYeFZaWmJvLzk4NUdRZ2hoSkNFREdRRVFvZ01JY2lNQ29pRk9JTURZbWxoCks3WmFXdVhWMW41elA1Ly9pMzV4My9YdDdsdDF1M3FxVzNYN1dsVTlWTXBxN2JZY2FsS3JyVkxMVXNBQkl3S2lnQVprQ0JBZ1pEam4KL3lLZURsUEllWGIyM21zLysxbmZWMWJweVZsNzVleVY1Nnk5bjdVVGFaUlN5ZzVKNlFDVVVpcGJXckNVVXRiUWdxV1Vzb1lXTEtXVQpOYlJnS2FXc29RVkxLV1VOTFZoS0tXdG93VkpLV1VNTGxsTEtHbHF3bEZMVzBJS2xsTEtHRml5bGxEVzBZQ21scktFRlN5bGxEUzFZClNpbHJhTUZTU2xsREM1WlN5aHBhc0pSUzF0Q0NwWlN5aGhZc3BaUTF0R0FwcGF5aEJVc3BaUTB0V0VvcGEyakJVa3BaUXd1V1Vzb2EKV3JDVVV0YlFncVdVc29ZV0xLV1VOYlJnS2FXc29RVkxLV1VOTFZoS0tXdG93VkpLV1VNTGxsTEtHbHF3bEZMVzBJS2xsTEtHRml5bApsRFZ5cFFNSVdydDBBUEdTSkVrK2VhUU5YdFBEQUNtalYvaG92Y3picW9ERXZtQXBYeVJJa0VNQnJVeGlQVzMwWi9tNkpIMDh5UWZzClpEY0RJRlcyVkZ4b3dWSWpTVkJORFpkd0k4Vk1aaHgxaHArYUdybzR5b3M4UnhjNzZKTStIR1V6TFZocWVFbHFLV1lsMTFCR0RYVWUKZjBvRkZjQWNycVdidDNtS1RqN25wUFNoS1R0cHdWSVhsa2NwdFR4Q1BVc3A4T0huRlRBZldNRks5dklqWHVVWXg2VVBVZGxIQzVZNgozeGpHTXB1N3FHT043NStRZWN5amxxdlp4eS9vb0pjZStraHJiMHRsSnhIM1Q0cGVKVFNVVHg0cnVJdzJyZ3Y0blE3d0xFZnA0Z1NkCi9JcUREQVJSdHZRcVliem9Da3NOeVdVc3E1bkNlaGFIOEc0VmJDTEZaK3psSGZKNG4zMTAwVU5LT2drcXlyUmdxVUVKU3JtQ0JyNUIKSGZtaHZXdVNRcElVTVpWKzB2VFRwd1ZMWFl3V0xBVlFUQ09yZVpTeGxJZjh6a1UwVVFBa0tLR2NMWFFDU1JKeXQ1cXFLTk9DcFdBOApiZHpHYlZRTHZIYytwVUFQUlp5Z25CN3k2YVdIYnRKQVV0ZGI2bXhhc0ZRbGM3aU5XME5mV3cwcG9vbGErcWtHSnROTkp6czRET1NRClM1K3V0TlFRTFZndVN6Q09NdTdqY21ZS2xxdk1LZ3Z5T1UwNW5SVFJBM1RUSzUwZ0ZUVmFzTnlWb0lSRjNNaFh2eXdYOGtxWVN4a2QKSklDQ0wxZFpTcDFCQzVhckVreGdLVi9sRmdxbFEva3ZCVlNSVDRva2VhQ3JMSFUrTFZodVNqQ1JKWHlWMjN6WmR1T256RlhEUG5TVgpwYzZqQmN0RkNTYXlsRHNpV0s2R3JocWlxeXgxUGkxWUxwcklZdTdrcGdpV3EwRzZ5bExEMElMbG1nUVRXY0JHcnFkSU9wUmg2U3BMCkRVTUxsbHNHeTlVOTNCamhjalZJVjFucUFyUmd1U1ZCRTNkYVVLNkdWbGtwMG5TelZ6b2NGUTFhc0Z5U29JcTFyTFdnWEEwcW9va2sKUjltbG4xTTFTRDhJTGhuUHRUeEFpWFFZV2N1bmxGNE9jWkRQNktXTEh1bUFsRFF0V080bzRsSVdSdWcyMGV5VU1KY3hRTUdYa3h5VQowN1JndVdJc2M3bU5EZFlWckFLcTZPVnpEbktRWHIxYTZEcDk4ck1yaWxuTkJvdStEcDRwbDNGVTBrS1ROZDAzRlJCZFlibGhBbmR3CmoraEVodEVvb0lwam5PYVlYaTEwblJZc04weGdLUTNTUVhpbVZ3dlZsL1FENElKeHJHQ1dkQkNqb0ZjTDFaZTBZTG1naHE4eFd6cUkKVWRLcmhRb3RXQzRZUXpNVjBrR01XZ0ZWOVBBSnV5TzdaVnVGUUs4U3hsMkNtZndwcmRKaEtPVUhMVmh4bDBzVmsyTHlleTZnaWtZYQpxZEpWbHF2MEsyRzhKWm5MTjVncUhZWlB0SS9sUEMxWThaYWtua3Rqc3g3UlBwYno0dkZWUVYxWWtoWnVaYngwR0VyNVJRdFduT1d5CmtKdGl0cDJsZ0NydFlibExDMVo4SmFobVh1eSs5SmN3bDdtVzdvbFVvNllGSzc3R3NvNzdZN2NXMFN1RlR0T0NGVmNKSmxBWDA1TzYKaERiYWRKWGxJaTFZY1ZYTUhXeVVEaUlnMnNkeWxoYXN1Q3FNeFlZY3BjNmlCU3VlSnJDT1ZkSkJCRVpYV003U2doVlBFL2tLemRKQgpCRWF2RkRwTEMxWWNqV1ZSYkxialhJaXVzSnlsQlN1T3B2QUFiZEpCS09VL0xWanhrMDhqazZTRFVDb0lXckRpSnNFY0htZW1kQmhLCkJVRUxWdHprVUVGZDdEYmtLQVZvd1lxYkpITjRnRnJwTUpRS2hoYXNlRW5Tek9YV1BkMVpxU3hwd1lxVEpOTzRXaS8zcS9qU1hrZWMKNUxHQ08zUjlwZUpMVjFqeGtXQVNMZm9uU01XWkZxejRHTWQ2SGlSZk9neWxncU1GS3o2S3FOT3ZneXJldEdERnhRUTJjTHQwRUVvRgpTd3RXWEl5amxScnBJSlFLbGhhc2VCalB0U3lURGtLcG9HbkJpb2NLMXRJaUhZUlNRZE9DRlFjRnpLWk9PZ2lsZ3FjRkt3NmErQk9kCmY2VmNvTGNaMmkrUFJpWkxCeEZWN1dmK2oxd0dTRXRIRks3MTBnSDRURmRZdGt2U3luOW5pblFZVmlpaVNEb0VOVHBhc0d5WG9KcHAKdWxMT1NnSGpwVU5RbzZNRnkzYjUzRWVaZEJDV3lLZUtzZEpCcU5IUWdtVzNKTXRacWV1ckxCVXlsMm1Na1E1RGVhY2ZkYnVWY3BQTwp2OHBhQ2ZNcEpZY1A2WkVPUlhtakJjdG11YXhtbFJhc3JCUlFRaVB6dVlGeC9JUU9VdElCS1MvMEs2SE5xcmxQNzIvUFVnbHR0RkZDCkEzZXpXSXU4cmJSZzJXc3NHMWdvSFlRMWhwNFdQWTNIK1lyT0RiT1RGaXhiNVhJWmQxQXNIWWFWbWxqQUZHMkgyRWgvYWJZcTRFcG0KU0FjaHBJY3VPZzBhNTRQOXE4WXZWMWlRejFvK1ppLzkwZ2VpVE9rS3kwNWp1SjE3bmIxdnU0dXRiS1VyNi8rK2hEWldzb0s1bEFDRAp1d1B1WVpsK0xiU1BGaXdiNWRESWVxcWx3eERUUTZmaENxdnFyQlVXd0hKdVpRbzUwb2VpekdqQnN0RkVibUtXZEJEV204V3lMMWRjCnlocmF3N0pQRGpPNDI5bjVWejEwc1p2ZFdhK3d6dTFmRFZuR0tUNmdpd0hwUTFMWjB4V1diWkswOE4rWktSMkdtQzYyOGdvdnN5WEwKSHRhNS9hc2hTYTdrQ1dib09XQVRYV0haSlVFRmkyaHorQ1Ryb2ZQTEZkYkk4aW1pbGlhYW1VclZCZjU5THMzTTVURDdYWnVTWlM5MwpQL2gyU3RESTdVeVNEc01TUlRUUlFpWGpodjNEM01RR0drbElCNnF5cFNzc215Um81aHVzY3ZweXZNa1Z3Z3RkSFR4YklhczVSQmNmCjZockxEcnJDc2trT003bmE2WElGWFd6SnVuK1ZTeEZWdE5CMGtUdldDcm1lbVhwN2d5MjBZTmtqUVJVcm5MMVpGTTdzWDJXM3dpcWsKbmlacUtiMW9rUi9MWXFyMGE2RWR0R0RaSXNFRTFyR0pRdWxBQkpuZjRUNzNBbGNIejFYTTExbkhCQzFaTnRDQ1pZc3h0TExJNlhMbApkLzlxU0NIemFOVkpwRGJRcHJzdEp2QVYxdW9mbUt4bDVsOWxJNWRiMktkelNHMmdKNEFkSm5BSGYrejBNQm5UL3RYUS9LdHNsUERICjNNRUU2WU5VSTlHQ1pZZHh0RHE4MlJuTTczQTNWVTByNDZRUFVvMUVDNVlOeG5NTlM2U0RFR2F5d2pMcFh3MVp3alg2M01LbzA0SmwKZzBtc2MzajNvTG5oOXc5ZXpFelc2UjZDcU5PQ0ZYMEZ6S0ZXT2doUlh2cFg1aXNzcUdXT1BwNGkyclJnUmQ5MEhtV2VkQkNpZ3U1ZgpaY3pqVWFaTEg2eTZHQzFZVVpmSFpPZS9xQVRmdjhvb1l6SjUwb2VyaHFjRks5b1N6T0V4bXFYRHNJaTMvbFZHQzQ4eFIrOTVqeTR0CldOR1dReldYT0wzZDJXUjFsVS9wR2ZPdnZLeXc4cGxCdFc2RmppNHRXRkdXWkJZYkhmOUNhTksvR25uKzFjZ21zWkZaZWw1RWxmNWkKb2l5SDJhelIvWU1oOWE4R0ZiR2EyYnJHaWlvdFdOR1ZvRjZmbldja20vbFhJOHRuR2ZYYXg0b21MVmpSTlliVmpvK1RDV2IrMVVpSwoyTVJxbmQwUVRWcXdvaXBCS1UyT1Q5TXdmMEpPTnZPdlJwWkxFNlc2eG9vaUxWaFJWY1R0M09kNHdRcTdmNVdSeTMzYzd2UnMxOGpTCmdoVlZoZFRyYzRrTm1NeS95dWFuMVR2OVpUeXl0R0JGMHdSdTR5YnBJRVFGTy85cVpEZHhtODdIaWg0dFdORTBuaVZNa3c1Q1ZGajcKQjRjempTVTZiQ1o2dEdCRjBUaFcwaW9kaERDcC90V1FWbGJxU0wrbzBZSVZSZFY4MWZtQ1pXSjArd2VIMDhwWEhaL3lHa0Zhc0tKbgpjRCtieThLYWZ6V1NhbWJvamJ2Um9nVXJhaEpjd3A4d1Z6b01VZEw5cTR5NS9BbVg2UDFZVWVMMmZUNVJsRU1sbFk3L0lSbGFZWTJzCmdKSkFWbGNBU1NxcEpJZCs2WVNvRExkUGpPaEpNb2VIYVpJT3d5TEI5Szh5bW5pWU9YcVdSSWYrS3FJbFFSMlhPajFYUENyOXE4eFAKdjVRNi9WSVlIVnF3b2lSSkM3Y3hVVG9NVVZIcFgyVk01RFphOUR5SkN2MUZSRWtPODFucitCNDIrZnV2emxiRVd1YnJmS3lvMElJVgpIUW1xbWFlWFFRd0UyNy9LeUdVZTFmcTFNQnEwWUVWSEFUZnhnTk5iYnFQVnY4b281QUZ1Y3JxdkdDSDY5endxRWt5Z3dmSFRvb3V0CnZNN0xkRVNrZjVWUlFBTVQ2Q0V0SFlqU0ZWWlVqR2NER3gzL2ZVU3RmNVdSWkNNYmRDdDBGT2dLS3lvS21VYWxkQkFXS2FHTkpheWcKSlpTcFlaVk1vNUJqMGdldDNQNkxIaDFGM01RYTZTQkVSYk4vTldRTk4xRXNtU0FGV3JDaVlpS3JISCsrYzlUdXZ6cFhNNnQwQXF3OApMVmhSTUpiRmpwZXI2UGF2aGpTemlMRnlDVktnQlNzYTZybWZlZEpCV0NTYys2L09OWS83cVpjK2ROZHB3WktYUjRQamo2T1BldjhxCll4SU41RWtrU0dWb3daS1c0QktlWUk1MEdLS2kzci9LbU1NVHpOUjczaVhwYlEzU2tsUlM2L2p2SVNyenIwYVNTeTBWSkJrSVAwVnEKa0s2d1pDV1l6UU0wU29kaEVabitWVVlqRHpCYnp4bzVtbnBaT1V6bkN0MC9hRUgvYWxBaFZ6QmR6eG81bW5wWnVWemgrSllQVy9wWApHZU81UWh2dmNyUmd5V3BrZzlQckt4dnV2enBiSVJ1WXBvMTNLVnF3Sk9XeFFHOUZOQ0RidjhvWXkzeGRZMG5SZ2lWcEF0T2NmdTZkClhmMnJqRndhZFZlaEZDMVljZ3BZeTBOT1Q4Q3lyWDgxcUpDSFdLc3JZeGx1My84anE0Qkd4d2ZLMkhMLzFia3FhV1FzcDZURGNKR3UKc0tRVWNpMjNTQWRoa1dqMHJ6SnU0VHJHU1FmaElpMVlVc2F6bkpuU1FRaXlzMytWTVpQTEhIKzZrUkF0V0RMR3NKaFc2U0JFMmRtLwpHdExLNGtpVVRzZG93Wkl4aWEreFREb0lVYmJkZjNXdVpYeU5DdWtnM0tNRlMwSXVVNm1XRHNJaTBlcGZaVlF6VlM5YWhVMExsb1NwClBNNFM2U0FFMmQyL3lsakNZMHlWRHNJMVdyRENsNlRjOFlFeXR2ZXZCdVV5bVhJOWc4S2w2UTViZ3FrOHhBenBNRVI1V1dGRmEzVTEKNkJJZW9sbjNGWVpKQzFiWUV0U3pWQytKR3lsaGJzVDZWNE9LV0V5dEZxd3dhY0VLVjRJcHJLTk1PZ3hCOGVoZlpaUnhFMU8wWklWSApDMWE0a3N4alF3VFhDdUV4N1YrVjBFWmJaRE5XeWdibTZWa1VIazExdUVwcGplUktJVHh4NlY4TnhkZEtxWFFRN3RDQ0ZhWjhydU1SCkhVMFNLOFU4d25WT0R3a0tsUmFzTUJYUjZQUjgwWGoxcnpJS2FkU0xLR0hSZ2hXZXNhemxYcWYvRm52cFgwWHZEdmR6NVhNdmE1MysKUXhRaWwyOWZERnNCMDJtUURrS1V5ZndyT0hPRkZXME5US2VBazlKaHVFQlhXR0VaeTFWY0l4MkVDc2cxck5ZMVZoaTBZSVdsaEd1WgpKeDJFc0I0Nlk5YS95cGpIMVV5UURzSUZXckRDa1U4cnpkSkJpT3RpUzh6NlYwT2FhV1dNZEJEeHB3VXJIRFU4d09YU1FZaUs1eFhDCklaZnpBSk9sZzRnL0xWaGh5S1UyOG8zam9IV3hsYTFXVDJjWVNaWGpNemhDb1FVcmVBbWFlSXdGMG1FSWkyLy9LbU1CajlHayt3cUQKcFg4UmdwZWdqS2xPMzM5bHFvUTJsckNDRmt2NlY0UHltVW9aQ2RMU2djU1pyckNDbHFDSlRZNVBwb3g3L3lwaktwdDBqUlVzTFZoQgpTektOcXh6ZlB4aVBDYU1qSytZcXB1azVGU1JOYnJBUzFMQ0s4ZEpoQ0xQOUNUblpHODhxYW5TTkZSd3RXTUhLWVJsMzYvZ1JBN2JkCmYzVzJVdTVtR1RuU1ljU1hGcXdnSlpqSURNZTNiTGpTdjhvb1pBWVRkWTBWRkMxWVFSckRqWHpUOGRFanJ2U3ZNb3I0SmpmcVBlOUIKMGRzYWdqU1dXaXUvMlBqSlpFSkRBU1ZXcjY0R2xWREwyQ3pYazhxUXJyQ0NNNDRiK0pyK1NUQmdkLzhxSTVldmNRUGpwTU9JSnkxWQp3U2xnSHRPbGd4RGxXdjhxWXpyekxEK0N5TktDRlp3YWxrdUhJTXkxL3RXUTVkUkloeEJQV3JDQ2tzOVZ6SmNPUXBnNzkxK2RhejVYCjZXYXNJR2pCQ2tvNWM2UkRzRW84K2xkRDVsQXVIVUljYWNFS1JnNjFWRXNISWNyVi9sVkdOYlY2QTZuL3RHQUZvNDVIV0NVZGhDaDMKKzFlRFZ2RUlkZEpCeEk4V3JDQWtLS1hlOFI2R3UvMnJRZm5VVTZwM3ZQdE5DNWIvRWpSd1A2M1NZVmdrYnYyclFhM2NUNE9XTEg5cAp3UXJDWkpiSDZ0UXpaYks2eXFlVVdwcG9abXFzVmxoUXd1VTY1ZDF2V3JEOGxtQXkxenAraGNpa2YxVkVFeTFVTWk2R2V3SW1jUzJUCmRZM2xKeTFZZmtzd2w0MVVTSWNoeXZYK1ZVWWxkekZYQzVhZnRHRDVyWVNadW8vTVFDNUZWTkZDVXl5bldveGpwdFBOQWQ5cHdmSlgKSHF0NTNPa3ZoS2IzWHhWU1R4TzFsTWJ5cW1vRmo3T2FQT2t3NGlOK2ZRTlpCZFF5VVRvSVVWMXM1WFZlcGlQckp6elBqZG5Wd2JOTgpvSllDK3FURGlBdGRZZmxwRE5md1FDeFhDdG5UL3RXNXgvZ0ExK2hBUDc5b3dmTFRHR2JRckRuTldnbHR0TVY0ZFFXUXBKa1pXckQ4Cm9pZVhmd3E0Z211bGd4RGxaZjlnbkZkWEdkZHloUU5IR1FvdFdQNHA0bXFXU1FjaHl2WDlnOE5aeHRXeHZBWXFRQXVXWDNLWlFiTjAKRU1LMGZ6V2NabWJvQlM0L2FCTDlVc1g5WEMwZGhFVkthR01KSzJpSmVROXIwTlhzNXhQMlNvZGhQMTFoK1NOSkpaT2R6cWJyODY4dQpMc2xrS3AzK2ZQaEVVK2lQZWg3aE11a2dSR24vNnVJdTR4SHFwWU93bnhZc1B5UW8xU2M4YS8vcW9ncVpvZk94Ums4TDF1Z2xxR2VqCjh3MTNFL0djZnpXU1pqWlNyeVZyZExSZ2pWNkNScTZoVkRvTVFkcS95a1lwMTlDb0JXdDB0R0NOVm9JS0x0ZjlnOXEveXNKRUxxZEMKUzlab2FNRWFyU1NMZUpCSzZUQkU2UjN1MmFua1FSYnBPVGNhbXJ6UkdzOTBuWDlsS080VEdvWTNqdW1NbHc3Q1pscXdSaWVQTlR5cQovU3VEMVJWQUxoVk9yckNnbEVkWm8vT3h2Tk03M1VkbkRMV09meDAwblg4RmNJQis2YkRGVkZMTEdKMlA1Wld1c0VaakRLdTUyL0dpCjcyV0ZkZExndjQyYlhPNW10WTZiOFVvTDFtZ1VNSmRXemFHeEwzaUtnOUpCQ0VuU3lsd252dzc3UWs4Mjc4YXdrTXVsZ3hEbFpYVUYKME10T1Rrc0hMK2h5RnVvYXl4c3RXTjRWczQ2cnBJTVE1ZlgrcXpRNytUR0hwY01YY3hYcktKWU93azVhc0x6S1lScU4wa0VJODdyQwpndjA4VGFkMCtJSWFtVWFPZEJBMjBvTGxWUTBQczBZNkNJdDl6cHQwU3djaFpnMFBVeU1kaEkyMFlIbVRwSXpKamw4ZkhGeGhtYSt1CllQQkw0WGQ0Ui9vQXhPUXltVEk5Kzh4cHlyeXA1eUVXU2djaHJvc3RudmNQcHZpQ1RvZnZ4MXJJUXpvZnk1d1dMQzhTVEtMTjhiYXAKOS81VnhoNytuSmVsRDBOTU1XMU0wbzNRcHJSZ21VdFF3NjFNa1E1RFdCZGIyVHFxNlF3RDdPSWo2Y01RTklWYnFkR1NaVVlMbHJrRQp6ZHhNdVhRWXdyejNyNFljNFNlOEtuMGdZc3E1bVdZdFdHYTBZSmxMTXN2SlNRUCs2Mk1MZjVBT1FsQUpzL1FNTktQcE1qZUpUVlJJCkJ5RnE5UDJyakpPOHdYdlNoeU9tZ2sxTWtnN0NMbHF3VE9Xd2tHcnBJSVQ1TjJHMGgrZHBKeVY5UUdLcVdhZzNrSnJRZ21VcW55cW4KNXhuMWNwaTk3R0E3dTN4WVlVRVB1OWd2ZlZCaWNxZ2lYem9JbTJqQk1wUEhTaDV3K29hR2JuYlFRU2ZkUHQxRGRacWY4UjFuNzNrdgo0UUZXT3YwSDBKQVdMRE41ekdTZTAzZTQrOWUveWpqT0xrNUtINWFRWE9ZeFV3dFc5clJnbWNoalBsZExCeUdzbnhQc3A0TWR2cTJLCkJuaUZmM0IyUGhaY3pYd3RXZG5TZ21WaUhLdTUydUdjOWRESkxyYXpnNzBjcHRlbm41cW1rMWM1SVgxd1FwSmN6V3A5akVtMjNEMzUKek9Vd2hSYnBJRVFGOWZ6Qk5CL3lNNGVmYWRqQ0ZMMVdtQjB0V05rcjU0KzVXVG9JVWY3M3J3YWwrWVFmc1Z2NjhNVGN6Qjg3djNNaQpTMXF3c3BYUWdUSUJTdk1GSHpqY2VwOU1tVzdTeVlZV3JHeFY4eUNycElNUVpycC8wT1RUdFpOdjg3YjBBWXBaeFlQTzM0NmNGUzFZCjJTcGhsdFAzWDRINS9DdVRUMWVLL1J5U1BrQXh4Ym8vTlR0YXNMSlR4UjNNbGc1Q2xHbi9LcDl4aGx0dTlqazhnUlJtY3dkVjBrRkUKbnhhc2JDU281MFo5d3JQUi9Lc2lTZ3dMVmkvUHNWbjZNTVZVY2dQMTJzY2FpUmFzYkV4a2tmTzc2azM2VndWVTBjeDBpZ3pmWTQvRApreHVnbkVWTWxBNGk2clJnalN6SnBUeWl6emd4VUVJYlY3T0pOc1BQMTFGZVpwdDA4R0xxZUlSTDlZeThPRTNQeUFxWnluanBJRVNaCjlxOEtxR0lxTTVoSm9kSDdkUE1mUENkOXNJTEdNOVV3WTg3UmdqV1NYRmJ5cVBhdlBOemhYczZqckRTOGMrMFVPeDBlTmxQcElXT08KMFlJMWtqeHFxSFU0VDZienJ3cW9vcEZHcWlpa2xockRiYjNkUE1YM25IMzRWOUpEeGh6ajdvbVluVHd1NTI2bmwrbW04NjlLYUdNbApLNWhMQ1lYY3plV0dKK0F4UHZWNTQ0OU52R1RNS1Zxd0xpNmYrU3h6ZXBIdXBYODF1TUlxSUpkbHpEZWNxTm5Mei9nN1p3ZjZlY21ZClU3UmdYVXdlYzFqbThNUnhHTzM4cXhUTG1HTlU4Tk4wOHBadm8ydnNNNWd4WFdNTlF3dld4UlN4amhzZHo5RkpQczE2L3RXWnE2dEIKU1c1a25lRzBweFJiZVlaajBnY3VaREJqcG5ld09jUHRrL0hpa3RReFZUb0ljU2I3Qjgvc1h3Mlp5bVREWFlYYitWZStrRDV3UVZPcAowelB6d2pRdHc2dmdRZFpLQnlGcU5QMnJJV3U1MS9BTzdoU2ZzZFhoMXZ0YUhuVDh5WmZEMG9JMW5BUVRxWEc4L1dtNmYvREM4cGxxCk9PMHB6UWY4TlIzU2h5OG1ueG9tNnI3Q0M5R0NOWndxN3VNSzZTQ0VtZTRmUEg5MU5laEtIakJjTWZTem53TU9YKzY0Z3Z0MGRzT0YKYU1FYVRqa0xLWlVPd2lJWDdsOE5LbVdoOGVieEhmd2xiMGtmbEpoU0Z1clE1QXZSZ25WaEZkekFkT2tnUlBuVHY4cVl6bzJHYTZ4ZQpQbVNQZEJJRVRlY0c3V09kVHd2V2hTU1l4aDJPajZ6MTl3azUxZHpCTk1PdXpBRis3UEFheTB2R0hLQUY2MEtLYVdXQ2RCRENURlpZCkYxOWREWnBBcStIZFJTZDV4ZUVwNzRNWmMzMG85M20wWUowdmgyVThUb04wR0JhNVdQOHFvNEhIV1dyNGVUdkJIL2hJK3VERU5QQTQKeS9SNWhXZlRnblcrTWRRNHZyN3l0MytWTVlINmkvNzc4eDNucC94VU9obUNKbERER09rZ29rVUwxcmx5V2NramxFbUhJU3FZSnp5WAo4WWlIK1ZoN09DeWREakZlTWhaeldyRE9sY2NVbWgzL2tQamR2eHFVU3pOVERETjdrcWY0ZTJlM1FnOW1URGRDbjBFTDF0bnlXTUt0CmpwY3JNOW4wcnpKeXVaWEZSaWRnbXNQc2NMWmdEV1pzaVphc0lWcXd6bGJBTXE1MHVtQUYwNzhhbE11VlhHN1l4K3JqMS94ZloyYzMKNUhJbHl3d3pGbXRhc001V1RKdkRHMElncVA1VlJvbzJ3MHYxYWZieUc0YzNRcHRuTE5hMFlKMHB5VUp1Y3p3bndmU3ZNcExjeGtMRAoyeUZUZFBCeloyZVFEbWJNN2Mva0dUUVJaeXJoTXVrUXJHTFN2eHB5bWVGTkl5ays0UCt4Vi9wZ0JWMW1sTjlZMDRJMUpFR0o0N2N6CkJObS9HbEptZkpkYmlpL1k2WERydll3UzNhUXpTQXZXa0hMdTRYcnBJRVFGMjcvS3VKNC9NdnpEa09aOS9vcjNSWE1qNlhydTBka04KZzdSZ0RTbWh6Zkg5OGNIMnJ6SXFXR0E4dUtlZmZRNFBUYTZnVGI4VUR0S0NsVkhLV2xxbGc3Q0l0LzdWb0ZiV0dyL3FZLzQzYjBvZgp0SmhXMXVwME50Q0NOYVNHbTUzZThCeE8vMnBRQTJ1TmgvZWM1aDEyU3lkSlRBTnJxWkVPSWdxMFlBMHE0bExqbVpqeEVrNy9LcU9TCitZWVAvNExEUE1zN0FwbUpoa291MVlkL2FjRWFsS0NWeDNUQ2FBajlxNHpwUE01Y3d5dGYzYnpJcTlKcEVqT2RSMm5WYTRWYXNBQUsKcURkOEVKWGJSdE8vR3ZvWjljYWpVMDd5bnNOamswdU14L1BFa0JZc3lHRUpqenZkSVFpemY1VlJ4K1BNTi96OEhlY24vTkRaclZOMQpQTTRTMXdmNmFjR0NIR3FaNXZTRzUzRDdWNE55bVVLRDhlblh6ZjVRTXhNbHVVeWhWZ3VXNjNKWXlFYkgyNW5oOXE4eWlybUhSWVluCllBKy81YVJncG1RVnM1R0ZicGNzTFZoNXpPTkt4NS93Yk1LUC90V2dmSzVrbnVHc3B6UWY4cVN6bTNTOFpDeG1YQzlZT1V4bnFYUVEKb2lUNlYwT1dNdDF3eGRETDIvUUw1Q2txekRNV0s2NFhySEhjeEIzYXZ3cTVmNVdSeXgzY1pIZy9WaDl2ODV5elh3dTlaQ3hXM0M1WQpDU3FaNm5nT3ZLeXcvRmxkQVNTWlNxWFIzVVVwM3VXZk9SSjZucUxDUEdPeDR2YkpXc2E5M0M0ZGhHVkttT3RELzJySTdkeHJPTHNoCnhUNjJPZHZIOHBLeEdIRzdZSTJud2Vucmc3TDlxMEZGTkREZTZCVXBOdk50ZG9XYXFTZ3h6MWlNdUZ5d3l0bklsZEpCaURMdFg1WFEKRnNDZ2t5dlphRGp0cVkvUEhINWFvWmVNeFliTEJhdVVwY1l6QStKRnRuK1ZVYzFTdzlFcGFiYnhGdzV2aERiUFdHeTRXN0JLV08zNApkdWZvbU01cXczVmJEKy9SS1IyMklQT014WVNyQlN0QkkxOWptblFZZ3FMUXY4cVl4dGRvTkx6eTFjbFRiQThsVTFIa0pXT3g0R3JCCkttU1d1MWRhQUcvOUszL3VjTCtRTW1aUmFQU0tZN3pBVzRGbktick1NeFlMYmhhc0pQTjV3dkV2aENZcnJIeEtxYVdKWnFZR3NzS0MKNlR6aFlYYkQyK3dMS1Z2UjR5VmpNZURjQVFPUVI3V3JUVXRQaW1paWhVckdCYmdub0pScXcxMXlSL2hubnBGT2pTRHpqTVdBaXdVcgpoeVY4MC9Icmc0TXJyQ2owcnpLcSthYnh0S2R1OWppN1NjZGJ4cXpuWnNGcVpMYno4eG02MkpKMS95cVhJcXBvb1NuQTIyenptVTJqCjRlbDNqSC9tZTg0TzlQT1NNZXU1VjdCeW1NZDZGOXVWWnpDZGZ6V1ZacHFvcFRUUU1sL0lldVlabllCcERyRGQ0ZGtONWhtem5uc0YKSzUrbHJIRjhmZFhGVnJaRzR1cmdtZkpadzFMRDM4eHBmc1dQc3Z4aUd6OWVNbVk1MXdwV2trWjlYR3JrK2xkRFdtazAra3ltMk1ITApEbStFTnMrWTVSdzZWQUNLdVowL2NucitWWlRsOGtmY1RySFJhd2I0Z0ZlY1hXTjV5WmpWM0NwWUNjcW9kK3lZenhXTi9ZUERTVkpQCm1lRjhyQzE4eitGSFU1aG56R3B1bmJ4bGJPSVc2U0NFbWQvaDd1LzhxNUhjd2liRFBRZ0Q3T2NUaDF2djVobXptRnNGYXp6VDNkd3kKZWdhWkorUmtyNFRwSHVaai9RVTdRb3N3YXN3elpqR1hDbFlaRzFnaUhZUlZncGwvTlpJbGJEQmNNZlR5Q1FkRGpqSkt6RE5tTFpjSwoxaVN1cGs0NkNGSFI3bDlsMUhFMWs0eGVrV1lIMytHOWtPT01Edk9NV2N1ZGdsWE1aZFJLQnlGTThnazVKbXE1elBESzF3bmU0bFBwCnNBV1paOHhTcmhTc0JNM2M3L2g4aHVqM3J6S21jei9OaGxlK3Z1QjVkb1llYVZSNHlaaVYzQ2xZdGE1T3dmWW92RHZjTDZTY1dzUFQKcjR0bmVGVWcwcWd3ejVpVlhDbFloV3gwZXI1bzFPWmZqV1FhRzQzM2UzYlQ0ZkQ5V0Y0eVppRTNDbGFTVm1aTEJ5SE1wSDhWeHZ5cgprY3ltMWZEVDJjVVArWWxZdlBMTU0yYWgyQjhnQURsVU1VWTZDR0cyOUs4eThxZ3luRU9RNWloN25OMms0eVZqRm5LaFlDV1p6VmVwCmxBN0RJbUhNdnhwSkpWOWx0dUhuOHdRLzV2dk9ib1gya2pIcnhQendBTWhsSHRjSnJoWGtSWFArMWNVVmNoM3pETCtTcHZqTTRidXgKdkdUTU92RXZXRW5xV1JUM1grTUlUUHBYc2xjSHo1UmtrZkZXOVQ1K3kxUE9qazMya2pITHhQcmdBQ2pnQnU1MWE4alplV3pyWDJVaQp1WmNiREtOSThRSC80V3dmeTB2R0xCUHpndFdlb0pRcGpxK3Y3SlhMRkVvTjd5NGE0R1ArNEd6SjhwSXhxOFM4WUZITVhkd2QrNk84CkdEdjJEMTVZa3J1NXkzRExTWXEzK0J0bnQrbDR5WmhWNG40cWo2TlJ2QmNqSytyenIwYUtwcEZ4aHEvcFo3K3pLeXh2R2JOSXJBdFcKZXdtM3MwWTZDbUYyOXErR3JPRjJ3L0taNWoyMlM0Y3R5RHhqRm9sMXdhS0VLNWdpSFlSRlpPWmZYZHdVcmpDTzZBUS80bVBwd01WNAp5WmcxWWx5dzJvdFlUb3QwRktKczdsOE5hV0c1OFEyc3U5Z25IYllnTHhtelJJd0xGdlhjdzB6cElFVFpNdi9xNG1aeUQvVkdyMGl6Cmw2ZjVSRHB3TWVZWnMwWnNDMWI3R0pwY21jSTRMTnY3VnhtVGFETGNDM3FZWnh5KzU5MUx4aXdSMDRMVm5tQU9UemkrdmpJVG5UdmMKenplVEo1aGplSGZSVVRaelFEcHdNVjR5Wm9XWUZpeHlxYVFxdGtlWERTLzlxNml1c0pKVVVXbDQrKzlCL3BFWHBRTVg0eVZqVm9qbApLZDJlWkI0UHgvVmJmSmJpMGIvS3FPZGg1aGw5V3ROMHNkZlp5UTFlTW1hRjJCMFFBRGswc2lDQ0s0VXd4YVYvbFlsd0FZMkcwNTZPCjhJLzhTRHB3TVY0eVpvRVlGcXoySkMyc2pldGwzVUJFdVgrVlVjUmFXb3crcnlrKzQwTlMwb0dMS1dJdExlMHhPOE5qZGpnQTVMR1UKVzF5WWJ6MnNPUFd2TWdxNWhhWGtHZWJobHp6dDdOZENMeG1Mdk5nVnJQWUUxZkdmdXppQ2VQV3ZNcExNcHRyb3lsYy83L01MNmJBRgpKWmxOZFh1c3JoWEc3OFFleDYzY3IvT3ZZdFMveXNqbmZtNDEzTmpienpaZWMzYU41U1ZqRVJlemd0V2VZQUwxa1QvMW9zU0cvbFZHCkFmVk1NRnhqdmNGM09TUWR1SmdDNnBrUXB6Vld6QW9XRTdpVERkSkJpSXBqLzJySUJ1NWtndEVyK3ZtY1RvZGI3K1laaTdTNEZheHgKTkR2K2ZKeDQ5cTh5S21rMi9Jb3p3T3Y4dWNPekc4d3pGbW14S2xqdEUxakhDdWtvaE1XemZ6VmtCZXNNVnd5bjJCWEw0cDJ0RmF4cgpqODBhSzFZRmkzTFdNRjA2Q0l2WTFML0ttTTRheW8xZWthYUR2Mk9uZE9CaXpETVdZVEVxV08yRnpLZEJPZ3BSOGU1ZlpUUXczL0F1CnU2Tzg1dlI4ckFibXQ4Zmt2c1FZRlN5bThqQ3Qwa0dJaW5mL0txT1ZoNWxxK0pyOXZPQnd5ZktTc1lpS1RjRnF6NmVCTXVrb2hNVzkKZjVWUlJvUGhuWFlIK1RGdlNJY3RxSXlHOWxqY214aVRndFdlb0kwbkhCK0liTWJHL2xWR0MwL1Faamp0NlJnZnhucmRlWEV0UEVGYgpITzdIaWtuQklvY0s2dU00L3lkcmJ2U3ZCdVZTVDRYaEpJS0RmSjlucEFNWDR5VmprUlNMZ3RXZVpDNzNVUzBkaHlnMytsY1oxZHpIClhNUDVXSWZZNC9BTnBOWGN4MXo3WnpkWWZ3QUE1TkRDU3Fmbk03alR2eHBVeUVwYURGY014L2huZnVSc3lmS1NzUWdLL0V0VWUvREgKa0dRYXF4emY3bXltaERhV3NJSVdDL3RYR2ZtczRpMjJHeFNnQVhiekRuZEpCeTRtbjFXODFXNlNNUitzOS9ubnhXR0ZOWVlydWRQcAo5WlZML2F1TVF1N2tTc01udy9UeUtzODdPN3ZCUzhZaUp3NEZLNTltcDl2dHJ2V3ZNbkpwTmx4WDk3T1pmM08yWUhuSldPVEVvV0ExCnM4bnhndVZXL3lvamwwMDBHNzZtbjEyOFI3OTA2RUs4WkN4aTdDOVk0MWhCc1hRUUZySDUvcXR6RmJQQ2VIYkRhL3cxKzZVREYyT2UKc1lpeHYyQVZPdjU4WnhmN1YwTW1HZmN1ZS9tTUw2VERGbVNlc1VpeHZXQVZjU00zU1FjaHlzMytWY1pOM0dqNGZLUVV2K2N2SFo3ZApZSjZ4U0xHOVlFMWdwZU1iY3R6c1gyVzBzTko0bnVaSlB1Q3dkT0JpdkdRc1F1d3VXQVVzZEx4Y21ZbFQveXFqaFlXRzVUZk5UbjdnCjhBeFM4NHhGaU4wRnE0Wk5MSlFPUXBEYi9hdEJDOWxFamVGcmp2Qkxka2tITHNaTHhpTEQ1b0tWUnlOVjBrR0ljcnQvbFZGRm8vSGoKUWcveXFzUFhDcjFrTENMc0xWZ0ptdmxUNWttSEljcnQvbFhHUFA2VVpzTmhNMS93QTE2V0RseU1sNHhGaEwwRkswazV0WTdmTUdvaQpqdjJyUWJsTXB0ejRrM3lNUFhSTGh5N0VXOFlpd2NxZ2dRU1g4Q0NOMG1FSTB2N1ZrS2s4eUNXR0s0WkRmRGVNbmZrUjVTVmprV0JyCndVb3loZVUyMzA4eWF0cS9HbExFNVV3eC9DeW4yTThuMG9HTDhaS3hTTEF3WkNEQlZLNWp2SFFZb3J5c3NPSzR1aG8wbnV1WWFyaGkKNkdhemROaUN2R1FzQXV3c1dMa3M1ZzdkUVdpa2hMa3g3RjhOSGQzdExEYnNhQTd3Smk4NE85RFBTOFlpd01hQ2xhQ2MyYmFQeVJnVgo3VitkTDUvWmxCdXVHSTd5Uyttd0JYbkptRGdiQzFZQmEzbkk3aTJjbzJUYXZ5cWhqYmJZcnE0R0ZmRVFhdzBMY2gvYjJPenNzQmt2CkdSTm5ZOEVhUjUzVDdYYnRYMTFZRVhXR28xUDZlSm52Y2t3NmNESG1HUk5uWDhFcTRoWTJXaGkzQ2xxU2pkeGkrS2Vzajg4NDVHd2YKeTB2R3hFTzJ6Vmd1b1U0NkNFSGF2eHBlSFpjdzF1Z1YvYnpDWC9DNWRPQml6RE1tekxhQ05ZNDFySlFPUXBTWC9sVTg3M0Mva0pXcwpNZnlTMDgySEhKY09XNUI1eGtUWlZyQW1jaDF0MGtHSTBoWFd4YlJ4SFJPTlhwSGlQYjdIUHVuQXhaaG5USlJkQldzTXJVeVZEa0pGCjJsUmFEUjlsZFlpWCtFdzZiRUhtR1JOa1Y4RnE0R0VXU3djaFNGZFhJMXZNd3pRWXZTTE41N3pFUWVuQXhaaG5USkJOQlN1WEdpcWsKZ3hDbC9hdHNWRkJqZUFmMzUvdy8zcFlPVzVCNXhzVFlVN0FTek9CUjVrcUhJY3BraFpWUEtiVTAwY3hVcDFaWU1KZEhtV0YwQjNlYQpMblp4VWpwd01lWVpFMk5Qd1VwU3dYU25OK1NZS2FLSkZpb1paOHZmVHQva001MEt3MDkySjMvREM5S0JpL0dTTVNGV0JNbmcrdXBlCjZxWERFTlpEcC9hdnNsRFB2WVlyaGhTZDdKVU9XNUI1eG9UWVVyQ1NOSE8xWGZma0JxQ0xMVm4zcjNMSnA0SVdtaHpNV2hGWDAyejQKMlQ3Q0QzbmEyWHZldldSTWhBVWhBZ25xV0dIUHBkZEFtRjRoTEdRaXpkUlM2dVRYNkRHc29NNW94ZERQaDJ5eDVId0lnbm5HUk5qeApDOHBqT1p1Y3V0SjF2aTYyc3RWZ3VtZ2UvYVNkblJsV3dpYVdHejRacG9mLzVEZk9yckc4WkV5QURRVXJ3VVJ0dHh2MXJ3Q084RHd2Ck9OZHdINUxQZENZYXJSaDZlWjJmT2p0c3hrdkdCTmhRc01aeU13ODcyRG9lblZOMHM1UHR6cTRZQ25pWW13MDM5dlpweHFLK0ZkcU8KZ2xWRHFYUVFva3o3VndCZGRQTVNmODFoNmVERmxGSmpYTEEwWTFxd1JxbUlkV3lRRGtLWWx5ZmtwSUFlOW5KRU9uaEJHMWhuZUkxVQpNMmFhc1pCRnYyQ05Zd0hUcFlNUVpyckN5aUZCR2hqZ3Qvd1ZlNlRERnpPZEJZYWpVelJqcGhrTFdkUUxWaUVyV0NnZGhIVnlTSC81ClQwZDUxK2xwVHd0WllUajlYek5tbXJGUVJiMWdsYk9lK2RKQmlQTFN2eHI0cjM5Szh4SC81UEJFemZtc3A5em9GWm94MDR5Rkt0b0YKSzQ4WjFFb0hJY3hMLzJyZ2pIOCt3TE44TEgwUWdtcVpZWGgza1diTU5HTWhpbkxCU3RERVl5eVNEa09ZbHhYV21kSWM1QTJIcjN3dAo0akdhREdjM2FNYk1NaGFpS0Jjc21FaDF4Q08wd1dmOEgxNlREa0pNa21yakVjQ2FzY2dPVFk1eU9jaGhMYk9rZ3hEbFpYVjEvbC9HCk5GM3NwVmY2WU1UTVlpMDVScS9RakpsbUxEVFJMVmdKcHJIQzhRMDVYdnBYNlF2OGY1MzhMYzlLSDR5WWZGWXd6ZkFyam1iTU5HTWgKaVhMQnFtRzhkQkRDdk54L2RTRXA5anJkUmg1SGplSHBweGt6elZoSW9scXdFa3ptSzFSSmgyR1o0VDlpeC9ncFAzTjJsMXdWWDJHeQo0UW1vR1RQTldDaWlXckNTTEdTVDB6c0l2ZDEvbFI3bTMvVHhMcTlGOXJjZHRITHVZYUhoMFd2R1RETVdpZ2lHQk1CRVdod2YyT2VsCmYzVXhwL2tEYnpnN1BHVU1MY1pYdmpSakVieFdHTTJDbGMrMVBPcjR3RDZ2K3dlSDA4dHYrSUd6Vjc1S2VaUnJEUy9oYU1aTU14YUMKYUJhc3NkUkVzYnBIMnNpait2cll3MTVudXpJVFBZeE8wWXhGYnRoTXpwOEYvQWJiekY4eWxodjRFNmNmbWRyRFFYYXdsUTcyMHAzbAphOUlYWFY4QnBOakhTUlk0ZXUwMWgzcjJzdFBvSzU1bXpEUmo1L0g3UnNvb3JyQUttRU96ZEJDaXZNNi9Hc2xKUHZhNHdTY09tcGxqClBMZFdNeGF4U2IvUksxZ0ZMR2VWZEJEQ1JydC9jRGdwM3VXQTlNRUpXc1Z5d3hOUU0yYWFzWUJGcjJCTjRGcVdTQWNSVy90cDU2QjAKRUdLV2NDMFRERitqR1RQTldLQ2lWckR5YUtGSk9naFJYbFpYMmY4V1U3eE9wL1FoQ21xaXhYQjBpbWJNTkdPQml0cGpvR3I0QmxkSwpCeUdxaTYyOHpzdDBHUFN2VE81STNzZHZxSFgybHBFck9jd243RFo2aldiTU5HTUJpdFlLSzBrbGxSR0xLV3lqbXpBNmtqU2Y4SDk0ClIvb2d4Wmgvd2pSamtUb25JeE1JQUZQNEpndWtnNGk1TkVlY0hwMnlnRzh5eGVnVm1qSFRqQVVvU2dVcnlTUXVpZklBL01BRjI3L0sKMk1PM2VGbjZVTVVVY2dtVERMT21HVFBOV0dBaUVnYVFvSkU3bVNZZGhpZ3Y5MStaNzZnZllDOTdwUTlWMERUdXBORW9iNW94MDR3RgpKa29GYXpyWE9kdmFIT1JsaGVWbDQ4aEJmc0RQcFE5V1RBblhNZDN3OU5PTW1XWXNJRkVwV0FrcVdPTG9Gb2pSR1dsRHpvWDA4bzdECmJXUVl6eElxakU1QXpaaHB4Z0lTbFlLVnd4VTg1UGorUVMvOUs2OGZvWk84eXB2U2h5eW1nb2U0d25CcXVXYk1OR09CaUVyQkdzKzAKNk8wTUQ1VzMrZTFlMWxjQVBmeWFuMG9mc3FDeFRETmN6MnZHVERNV2lHZ1VyREhjd0RjcGxnNURWRkQ3QjRmVHkyNCtkblowU2pIZgo1QWJERVpHYU1kT01CU0FxQmF1V1N1a2dMT1IxZlFWd211ZjVHMDVLSDRLWVNtb05Uei9ObUduR0FoQ0ZnaldXTmR3WmlVaWtlRmxkCmpiNmZjSUpQT0NGOTZHS1MzTWthd3phRVpzdzBZd0VFSVc4c2k1Z2RpVWlrK1BYOFFUTUR2TXkzbkIyZWttUTJpd3hQUDgyWWFjWUMKQ0VMYUdCYXpVRG9JWVdIZGYzVzJOSWQ0aStQU0J5OW9JWXVOdnVSb3hrd3o1anY1Z2xYR2JheVFEc0pSYVRyNE40ZW5QYTNnTnNxTQpYcUVaTTgyWXo2UUxWaTZOTkFqSElLK0h6b0QzRDE1WW1qMDh4Ujdwd3hmVVFLUFJpQ1hObUduR2ZDWmRzT3A0VE5kWGRMRWw0UDJECncwbXpuN2V5ZnRCRi9LemdNZXFNWHFFWk04MllyMlFMVnBKeXFpTTNSREJjd2M2L0d0a24vQjF2U1NkQlRDN1ZsQnVlQlpveDA0ejUKU0xKZ0paakMxMmtUakNBS3V0aktWcCtlN3V4RmlrTjg1dXp6amFHTnJ6UEZhTTJxR1RQTm1JOWtDMVlsQ3lnU2pDQUtwUHBYUS9ieQp2L20xZEJyRUZMR0FTc1BUVHpObW1qSGZ5QldzQkhYY3pHU3g5MWNaL2V6aVkra2dCRTNtWnVxTVRrRE5tR25HZkNOWnNHYXpubkt4Cjk0OENMLzJyMGQ4d2VyNHVmc29yMHNrUVU4NTZaaHVlZnBveDA0ejVSS3BnSlNpampYRkM3eDRWTW5lNG4rODBiL0piNldRSUdrY2IKWlVZbm9HYk1OR00ra1NwWWVYeUZSNXhlWC9WeW1MM3NZRHU3c2w1aDVRVDJFVG5GWm9jSDFKWHpDRjh4ZlBxZVpzdzBZNzZRS2xnNQoxRVpodW82Z2JuYlFRU2ZkQnRlYlVvR3Nyd0I2ZUpFZk9uemxhenkxaHR2Sk5XT21HZk9GVk1HYXhDYW5uNDhUL3Z5cmtaem1NL1k3Ck8rMnBrRTFNTW55TlpzdzBZejZRS1ZqNUxLZFo1SjJqbzU4VDdLZURIUVozVFFlMXZnTG81VG0reFRIcHRJaHBaam41UnEvUWpKbG0KekFkU0JhdlcyYjlNTUxpNjJzVjJkckNYdzFrK29qUDQ1ZmR4ZGpvODdTbEZyZkhwcHhrTHZXRGwvRm5BYjdEdC9QOHJuOFhjemJRbwpQSU5EeUVHMjhsdGU1ajI2c3U2Q0pBSmRYOEhnRTQ1aGxzUFhibmZ5bWRHMko4M1lpQm1iNWZNYlNxeXd4bk05cThXM1hVdVNtWDgxCmtqUUhlSldqa29rUmxHUTExeHRlQ05LTW1XYk1oemNOV3c1VGFBcjlYVlUyMHV6aWVRNUxoeUdtaVNtR1g3MDFZNllaRzZYd0MxWVYKRDNGRDZPOGFMZkw3Qnk4c3pTZjhrSjB5U1ltQUczaUlLcU5YYU1aTU16WktZUmVzQk9WVU9UNVFSbkwrMVVqU0hLTEQyU2ZENUZKRgp1V0cyTldPbUdSdVZzSnZ1dFR3V2hhZWJDZXJoSUZ0NGtZNHMyKzI1SkgyZGZ6V1NvK3psRXFiSUpFZGNKWGxzTmJ4VlFUTjJrWXpaCjNYUWYzRUhvOWdOVFRlZGZqUW41ZDVTaWs4OUR6a2wwRk5OcXZFZE9NeGJpcnNJd1YxZ0pxcm1YcnpoOEVSamdJTy96SGp1eUxsa0oKK2tLTzhDU2QxREF0NUhlTmlnSk84NEhoQ0dUTjJMQVpzM3VGTlpWYnFBajFIZTAzRVBqOVYrZnFvNE1QcFE5YlRBWHJtR3I0R3MyWQphY1k4QzdOZ2xiS1FDU0crWC9SRTgvNnI4eDEzK0xvWFRHQWhwWWF2MFl5WlpzeWo4QXBXRGt0NWxPclEzaStLb2pML2FpUTkvUEpDCld4UWNVY01qTERXZTNhQVpDK1YrclBBS1ZpRU5UZytVOFRML0tsZHMrOUkrZmlyMHpsRXduZ2JqV1NLYXNWQ21yNFJWc1BLNGl2OUcKU1VqdkZrVmU1bC9saVcxZzZ1VVQ5Z3U5dDd4Uy9odFhHWTZuMDR5WlpzeVQ4QXBXSGZXNmY5Q3dmOVViNmgxWVp6ckowL3h0UkNaMQpoUzlKUFhXR3A1OW16RFJqSHQ4b0RQbXM0QzdINzIvM012OUtjZ1RQTVQ1Mjl2U0RYTzVpaGVId0ZNMllhY1k4Q0tkZ0ZiQ0l4UTRYCkxDL3pyM0xKRVdtNFovVHhLLzVXOEFHdnNuSlp6Q0lLakY2akdUUE5tQWRoRkt3ODVyRFE2WUY5WHE0TzVnaG5MRTBuditlVWFBeVMKVWl4a2p0R1hITTJZYWNZOENLTmdsWEE3MTJ2L3l2aitLOG4xMVdBRTIzalcyUkhBU2E3bmRzUExSSm94MDR4NWVKUGdENk9XaHNEZgpKWDdDM3BCenZqUTcrQ2YyU29jaHFJRmFvek5FTTJhYU1XUEJGNnpKUE15YXdOOGwya3puWDBWRm12MjhiMkhjZmxuRHcwdzJlb1ZtCnpEUmpoZ0l1V08wSlNxZ1B2aFVYY2FienI2SWl6WGEremJ2U1lZZ3BvSjRTbzV0M05XT21HVE1VOUFxcmh2dFpFUEI3UkZ2VW5qOW8KWm9BREhIRDRnc2tDN3FmRzZCV2FNZE9NR1FtMFlMVW5xR0J4V05zaUk4cDAvbFhVZk16LzRuZlNRWWdwWlRFVmhpc0d6WmhweGd3RQpXTERhRTFSeUhZM0J2WU1WYk8xZlpmVFJ3YWZTUVFocTVEb3FqVTdBUGo3VWpBVlZzb0pjWVNWbzRTNHFBM3dIRllaRFBNMmIwa0dJCnFlUXVXZ3hQUDgyWWFjYXlGbVRCS21hMjAvTVpiTzlmWlp6aUpmNVRPZ2hCNDVsdE9OYjdKQy96bW5UWWdzd3psclhBQ2xaN0xpdDQKUE1qMm13VzgzT0VlUlNmNEF4OUpCeUdtaHNkWlliaXg3Q1J2YThhQytOSEJyYkRHVU92MGZGRXY4NitpNmhUUDgwOE9YL21hUUszaAprNTVPOEIrYXNTQitjRUFGcXoyUHEvaTYwOC9IOFRML0tycDYrTXp5VmVKb0ZQTjE0MmxQcHpSalFld3JER3FGbGM4MFdoeWV6eENYCi90WFEwVHpGdHh4K1hHZ0wwd3hIcC9Ud2IzeEhNK2EzUUFwV2V6NUxXZWYwZG1kdjg2K2lyTXZwTFNkSjFySFU2QVJNMDhWMnpaai8KUHpZSWhheGd1Y01GeTh2OHE2aEw4VHIvMTlrdk9VbVdzOEp3YW5rLy82a1o4Ly9IQnFHRU9ZRW5KTXJpY25Yd1RHazZlWVVUMG1FSQptbU00T2lYTlhzMlkzejh5Z0lMVm51UXkxb2FRam1pSzA5WEJzNlhZd1MrZG5mWUVhN25NOEh6UmpGM1c3bk9GQ1dLRlZjYXlVTklSClRmRzZPbmltTkIveWZYWkpoeUZvR1dWRy83MW16RFJqSS9LOVlMVW5LUEU3U0t2RTYrcmcyZEljWUhkTWVuSmVsQm1QVGtsejBQV00KdGZ1NlNTZm56M3lPY0ZzbEQzTnJPQTlWaktRajdLU0RMZXlrVyt3aFhVRWUzVDdtVUNzZGhwQXE0RjNEcnBSbTdOMVpQdmJ4L1A5SwpXTW9DeXNQTFNLVEU4ZXJnMlFiWXh3SHBJTVNVczhCNFdGSy9ac3pQSCtoendXcFAwTWJNTURNU0tYRzhPbml1dmZ5ZHc5T2VadEptClBJZkErWXo1K2FYUTd4VldDYmRSSFdwQ29pVE8vYXVNMDJ4bXAzUVFZcXE1eGZoUy9XbTJPSjR4SDdmbytWcXcyaE0wT2o2ZndRVkgKZVpFdDBrR0lxYVhSZUkzbGZNYjhXMlA1dThKSzBCanNNek1peklYVjFhQ1RQTS9QcFlNUVUwYWRjY0U2d1l2OFNqcHdNV1UwK0RmTwp6OStDbGNOWHFRczlJZEhnUXY4cTR5VHZza2M2Q0NIVDJVQ084YXRPOFlGbXpBOStyN0RjZk9CRWZPOXV2N0FlZnNZL3h1N0cyR3g1Cm1hSjdncWMxWTM3d2U0VTFLZVJVUkVOODcyNGZ6a24yT2pzNnhkdFpjMEl6RnFrZkJPMEpaamg2ajdzNy9hdU1YcDdtcnh6ZEpUZVoKYVI1Nk1xZjVkLzdhM1l6NTFYYjNjNFdWWkxhalE1SGpOdnRxWkdrT3NabFQwbUdJS0tiQnczbVQ1aUR2T0p5eENCYXNYSlk0K2xENgprM3dhNDd2Ykx5ekZkb2VPOWt5VG1POXBsdTRBSFE1bnpLZTJ1NThGYXd6WE9Ub1V1WXN0VGx3ZFBGT2FYVHpuWkZlbWhBMmVIckNRCjVrT0hNK2JUZkhjL0MxWWlpQm5Pa2VkZS95cWpqMzludjNRUUlyeWVOWnF4NlB3Z1ozV3hsYTJPcmE0R3BlbmtReWUvNUhoOWZKZG0KYk5UOExGaHBaeTdxbjZtSFRnZFhWd0JwM3VVdjZaQU93eUlwM3VWL2FjWkd3OThWbG90L08xeld4eDRPU1FkaGxUNzJhY1pHdzkrQwpGYitCZFJmbmJ2OHE0Mk8reFdicElLeXlRek0yR3Y0V0xOZStFcnEwZi9EQ1R2TWVlNldEc0VxUFptdzB0T251bFd2N0I0ZXpuNSt5ClRUb0lxeHpnR2MyWVYxcXd2SEp2LytCd2VYaUIxNldEc01weG50ZU1lYVVGeXl2dFgyV2M0QjMyU1FkaEZjMllaMXF3dkhKdi8rQncKanZPdi9GZzZDS3NjMVl4NXBRWExpL2cvSGNmTWNYWTd1ZVhFdTI3MmFNYTgwSUxsaFY0ZFBOdEpmc0xmYStFMmNJSjJ6WmdYV3JDOAowUDdWMmRJY3BNUHhpdzltMG55aEdmTkNDNWJ5UXordjhDL09kL05NOUduR3ZOQ0M1WVc3K3dlSGsySW56MnRHREtUWXljODFZNmI4CkxWaXVqSmR4Y2Y3VlNBYm80RlZIR3NuK2ZNNVRiSGNvWXhHY09EckFMdi9HU0VTVzlxOHVMTTBIL0lNVG0wNVM3UEpsMTJ5S2R6VmoKcHZ3c1dLZDUwb0hiNGR5ZGZ6V1NGQWZZNDBBamVSOVBjdHFYbnpUZ1VNYjYvUGxSZmhhc0ZQc2RHTEt2L2F2aHBIbUhQM2RnbDl3cAo5dnYwVFdKd29wZ2JHVXY3ODZOOExGanJVMngxWUlXbGh0Zkh4M3doSFVUZzlySFZ0OVpITDd2ZHlOaDZuekxtYjlQOVdNd3YwMnIvCmFpU2Y4Zzlza1E0aVlOMitQbDN3WTgyWUNYOExWb3FYT0J4Nk9zS2pkN2lQcElmZnMwczZpRUFkNWlWZkx5MmQwb3laOEx0Zy9ZNmQKb1Nja0hEci9LanRIK0NYYnBZTUkwRTUrNS9PMThQaG43TldvRml3NEVOdUhjZXY4cSt3YzVXbCtMUjFFZ0k1eHdPZWZHUCtNN1YvdgpVOHZkNTRLMVBzMm4vQ2FtSjdUMnI3SjFrdTIrbjlSUjBjOXYrTlN2SzE3L0plNFo4L0ZlTTU5WFdPc0grQm0vRHpjaklkSDVWOWs2CnhyL3dBK2tnQXZKN2ZoYkFvMVppbmpHL3JoQkNFSHNKdTJKNG1WYm5YNWxJYzVROU1WMkhmaEhJNVJiTldOYjhMMWg3ZUNlc1hJUkcKcnc2YU9jWFRmRGVXSitBNzdBbms1MnJHc3VSN3dWcmZ5M094ZSs2YTlxL01wUG1jelRIc1pXN211WURXMXpITzJIcGZNeGJFZUprOQp2QmRTT2xSVTlmTW0veDY3YnQ5N0FhMnZRRE9XcFNBSzFqRmVvU09VZElSRjl3K2FTdEhCVXh5WERzTlhIYndTNEUwN21yR3NCRkN3CjFoL25HWjROSnlNaDBmbFg1bEo4eXR1eEt2TFA4a3lnQlNXV0dWdnZjOGFDbVRoNml0Mnh1YTlFKzFmZXBOaktkMkswNmVRQXV3T2UKUmFJWnkwSXdCZXNrUCtGN01Xa2g2dndyci9ycDVJdVlqSFRzNTN2OEpQRHBvSnF4RVFWU3NOYW42V0ozVEZZazJyL3lLczAyL21kTQpibkxwWVRkZHZ0L2hmaTdOMklpQ2VnaEZMeS93M2RoZDgxQm1Uc2RreTBrMzMrV0ZVRzRZMW95TklPZlBBb2wzRnR1Nk9Va3hEWXdKCk5qT0I2dUVnTzloS0IzdTErSHJTUXgvVHFaQU9ZMVNPOFN3LzVQMlF2cXJGTEdPemZQN1J3VDNtSzBVSEwzSTAyTXdFVE85d0g2MFQKdk1MNzBrR00wbEZlcENPMHpwSm03S0lDSzFqcjAzekI2L3phMnU2UHpyL3l4MUZlNHhQcElFYWhoMS96T2w4RTNyOGFvaG03aUlDKwpFZ0xNWXRzUjlsQkhBN21CdlVsd2pyS0REL21FUGV5TjJlMTg0VHJOYnZLWVRhRjBJSjcwOEF2K25QZERMRmN4eTVqZlh3a0RMRmd3Cks3MnRuMU5Nb1NiQU53bENMMGZaU3djZnNvdFBPZURBczRDQ2xPSVVDWm9wa0E3RWc4MThqODJoOXk5amxERy9DMWJRYTUrRC9JRWQKekErd1Z4YUVibmF3ZzUzczVEMXR0NC9hS2JhU1J5NGJyVnN6cE5qQkh6Z1krdnRxeG9ZVmNDRlpuMklIMythRllOL0ZWNW5lVlFjZApPdi9LSjkyOHpac1dQcFQ5QmI3TkRwRWJPVFZqd3dqMEt5SEF0alRkREZCQlhjQnY1SmVqN0tDRG5YekVlK3ltTzRENWtpN3FwWk1jCjVsajFKZWQzUE1sdnhkb0JNY21ZVlQwc2dHM1F6eEZPTW9uYWdOOXE5REs5cXc0K1lnZTdPYXpseWpjbk9FNHhUZVJMQjVLbE4zaVMKWDNGUWNLTk1MREptWThGSzBjMEJ1cW1taWtUQWJ6YzZ1cm9LMGlrT1VjZ1VDMDdBRkcvemZWNWdyL0IrMkJoa3pNYUNCU21PYzVBdQpxcW1PYk1uUzFWWFFlampDQVFvanYvc2h4VnQ4bDUrelIvd1RFSU9NMlZtd0lNMXhqbkNZS3FvaWVzVlFWMWZCTzhVUkRsRVE2VFZEClAzL2d1L3lhVHlMeENiQStZN2JkMWpCa2dOMjhSSkpjNW9mMm50bnFwZnZMSzRNN3Y3d3lxSUp4aERkSWt1SzJ5RGFUdC9KOVhtSjMKSk1vVmFNYk9FZVk5NkFQczVoY2tTYkV3eEhmTmh0NTNGWlkwUjNpTk5FVDBCSHlUNy9NTFBvMU11ZEtNblNQY1RUTURmTW9MUUIvTApRbjNmaTlIVlZialNIT0czREFDM1JPNjJ5Ti94QTE2SVFPL3FiR21POER0QU0wWjRQYXlNTk1jNXlBbktJM09UZy9hdXd0ZkxRUTV6CmtpYkdTb2R5aHRkNWtoY2pWNjRHbmVZZ2gyek1tSzFOOXlGcHV2bUNMc1l6SmVDM0hwbGVHWlJ5bXM5NWl4TU1VRVNSZERBQXZNU1QKL0NLaTVRcmdOSjFzcHA4VWhUWmx6UDZDTlhoZjFtN2VvWXgraWtVbk9lanFTazRmeDlqR1IrVFNLUHhGcDRjT1h1Ti84RnNPUlBvNQpCTDBjWlJ2YlNkcVVNWHV2RXA2cG40TWM0ZjlqSG5ld1NxaVYyRU1YZTluT2R1MWRpVG5NbS9SeWtqdW9Gb3VoaDEvekwyem1BeXYrClhPM25KTDMwY3B1ckdaTmIzd3l3alVOOHpHR3VvVkRnTDBZWFc5bEJKN3YweXFDZ0UyeWxpMzA4eWxqS1EzLzNrNXprQmY2ZW5leTMKNWxrMXg5bENGNSs0bWpISkwyUXBPam5BRWQ1Z09XdER1ekd1aHk1NmdOMjh6bmE2NmRUVmxhZ1RmTURuN0tDUmIxQkhmb2kzRmZmeQpNMzdEUzNTUUNuVkEzMmdkNDEzMnNaTUdGek1tT3dzMHpRQWZjSkFPT25rd3BKTFZ4Vlk2Z2QyOHpDNzY2ZEhWbGJBMFIzaVdRdll3CmhmVXNEdWxkZS9sNy9wMTNyWHdPWUpwRFBNdFlGek1tUDd3NHhRRit3MGZzb1k0TkFUNHQ1TXlWMVc2Z2t3NDZwUTllZldtQTR6eEwKSGg5d0dXMWNGL0M3SGVCZjJjT1ArWncrcTlaV1orb1BPV00vWWlmUGNFQTZZNG1nMzcwOXl6Z1l6eGhhV0UwTjg1Z1hRQ0NkWjZ5cwpkak5Vd0ZTVWpHRXNzN21MT3RZRThzZDBNNXZaeHkvbzREVEhyUzFXWndvclk5czR4U256akszM09SejVGZGFnTk1lQUw5aENNWmR6CkY3VytGUzFkV2Rua05LZDVnNCtvNVNEMUxQWDFDdkptOXZJalh1VllyQjRxNGxqR29yTENPbE1oMVZSeEs1ZFN4S3hSL3dKMFpXV2oKSkxVVXM1SnJLS05tbE5OcWUzaWZidDdtS1RyNTNNS3h3OW1KYU1iOFhtRkZzV0FOeXFPSkVxNWpEUk1vTWU1dHBlamlVN29ZS2xpZApiTkdWbFdVU1ZGUERKZHhJTVpNWlI1M2hONElEZEhHVUYzbU9MbmJRSjMwNElZaGN4dHdwV0pBQWNtaGtHcGR3TjNsWlhadElraVNQCkwvaUlnN3pMQjZUcDVSaW5nVjZPNmVNa0xKUWdRUTRGdERLSjliUmxmUzk2a2o2ZTVBTjJmam40SkE3OXF1eEVLbU11RmF3dkl5UkoKempCZkROUG5KVFZCZ2dScEJvQStnN3RGN0xvVHgwVkprdVNUWi9SNzZtSEE0ZDlzSkRKbVhjRlNTaW0vUkhOY3NWSktYWUFXTEtXVQpOYlJnS2FXc29RVkxLV1VOTFZoS0tXdG93VkpLV1VNTGxsTEtHbHF3bEZMVzBJS2xsTEtHRml5bGxEVzBZQ21scktFRlN5bGxEUzFZClNpbHJhTUZTU2xsREM1WlN5aHBhc0pSUzF0Q0NwWlN5aGhZc3BaUTF0R0FwcGF5aEJVc3BaUTB0V0VvcGEyakJVa3BaUXd1V1Vzb2EKV3JDVVV0YlFncVdVc29ZV0xLV1VOYlJnS2FXc29RVkxLV1VOTFZoS0tXdG93VkpLV1VNTGxsTEtHbHF3bEZMVzBJS2xsTEtHRml5bApsRFcwWUNtbHJLRUZTeWxsRFMxWVNpbHJhTUZTU2xsREM1WlN5aHBhc0pSUzF0Q0NwWlN5aGhZc3BaUTF0R0FwcGF5aEJVc3BaUTB0CldFb3BhL3ovTzBwSVhIdkgyZDhBQUFBbGRFVllkR1JoZEdVNlkzSmxZWFJsQURJd01Ua3RNVEl0TUROVU1UazZNRFk2TlRZck1ETTYKTUREQ0NKc2pBQUFBSlhSRldIUmtZWFJsT20xdlpHbG1lUUF5TURFNUxURXlMVEF6VkRFNU9qQTJPalUyS3pBek9qQXdzMVVqbndBQQpBQmwwUlZoMFUyOW1kSGRoY21VQVFXUnZZbVVnU1cxaFoyVlNaV0ZrZVhISlpUd0FBQUFBU1VWT1JLNUNZSUk9IiAvPgo8L3N2Zz4K'
            );
        }
    }
?>
