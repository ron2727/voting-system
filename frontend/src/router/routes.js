import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue' 

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    }, 
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('../views/dashboard/Dashboard.vue'),
        children: [
            {
              path: '',
              name: 'Summary',
              component: () => import('../views/dashboard/summary/Summary.vue'),
            },
            {
                path: 'voters',
                name: 'Voters',
                component: () => import('../views/dashboard/voters/Voters.vue')
            }, 
            {
                path: 'voter/add',
                name: 'VotersAdd',
                component: () => import('../views/dashboard/voters/VotersAdd.vue')
            },
            {
                path: 'voter/:voterId/update',
                name: 'VotersUpdate',
                component: () => import('../views/dashboard/voters/VotersUpdate.vue')
            }, 
            {
                path: 'elections',
                name: 'Elections',
                component: () => import('../views/dashboard/elections/Elections.vue')
            },
            {
                path: 'election/add',
                name: 'ElectionAdd',
                component: () => import('../views/dashboard/elections/ElectionAdd.vue')
            }, 
            {
                path: 'election/edit/:electionId',
                name: 'ElectionUpdate',
                component: () => import('../views/dashboard/elections/ElectionUpdate.vue')
            }, 
            {
                path: 'election/:electionId/candidates/:electionStatus',
                name: 'Candidate',
                component: () => import('../views/dashboard/candidates/Candidates.vue')
            }, 
            {
                path: 'election/:electionId/candidates/add',
                name: 'CandidateAdd',
                component: () => import('../views/dashboard/candidates/CandidatesAdd.vue')
            },
            {
                path: 'vote',
                name: 'VoteActiveElection',
                component: () => import('../views/dashboard/vote/ActiveElection.vue')
            }
            ,
            {
                path: 'vote/:electionId',
                name: 'Vote',
                component: () => import('../views/dashboard/vote/Vote.vue')
            }
            ,
            {
                path: 'ballot/:electionId',
                name: 'Ballot',
                component: () => import('../views/dashboard/Ballot.vue')
            }
            ,
            {
                path: 'results',
                name: 'Results',
                component: () => import('../views/dashboard/results/Results.vue'),
                children: [ 
                    {
                        path: '',
                        name: 'ActiveElection',
                        component: () => import('../views/dashboard/results/ActiveElection.vue')
                    },
                    {
                        path: 'tally/:electionId',
                        name: 'ResultTally',
                        component: () => import('../views/dashboard/results/ResultTally.vue')
                    },
                    {
                        path: 'elections',
                        name: 'ResultElections',
                        component: () => import('../views/dashboard/results/ResultElection.vue')
                    },
                    {
                        path: 'winners/:electionId',
                        name: 'ResultWinner',
                        component: () => import('../views/dashboard/results/ResultWinner.vue')
                    },
                ]
            },
            {
                path: 'reports',
                name: 'Reports',
                component: () => import('../views/dashboard/reports/Reports.vue')
            }, 
            {
                path: 'reports/pdf/:electionId',
                name: 'GenerateReport',
                component: () => import('../views/dashboard/reports/GenerateReport.vue')
            },
            {
                path: 'settings',
                name: 'Settings',
                component: () => import('../views/dashboard/Settings.vue')
            } 

        ]
    }, 
]

export default routes;