<?php

namespace App\Exports;

use App\Entities\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class UsersExport implements
    FromQuery,
    WithHeadings,
    ShouldQueue,
    WithMapping,
    ShouldAutoSize,
    WithDrawings

{
    use Exportable;

    /**
     * @var Request
     */
    private $search;

    public function __construct(Request $request)
    {
        $this->search = $request->get('search');
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'id',
            'Role',
            'First Name',
            'Last Name',
            'Email'
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {

        return User::query()
            ->where('first_name', $this->search)
            ->orWhere('last_name', $this->search);
    }

    /**
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->role,
            $user->first_name,
            $user->last_name,
            $user->email,
        ];
    }

    /**
     * @return Drawing
     * @throws Exception
     */
    public function drawings(): Drawing
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo.png'));
        $drawing->setHeight(200);

        $drawing->setCoordinates('A1');

        return $drawing;
    }
}
